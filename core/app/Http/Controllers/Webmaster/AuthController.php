<?php

namespace App\Http\Controllers\Webmaster;

use App\Events\LoginAttemptsExceeded;
use QrCode;
use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Models\StaffMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:webmaster', ['except' => ['logout', 'enableTwoFactorAuth', 'disableTwoFactorAuth']]);
    }

    public function loginForm()
    {
        $page_title = 'Welcome to Dashboard Panel';
        return view('webmaster.auth.login', compact('page_title'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        }

        $webmaster = StaffMember::where('email', $request->email)->first();


        if (!$webmaster) {
            return response()->json([
                'status' => 400,
                'message' => ['email' => 'No account found with this email address.']
            ]);
        }



        if (!Hash::check($request->password, $webmaster->password)) {

            return $this->countUserLoginAttempts($request->email);
        }

        // now check if user login attempts exceed 3
        $this->userAttemptsExceedAllowable($request->password);
        //reset user login attempts
        $webmaster->login_attempts = 0;
        $webmaster->save();

        if ($webmaster->status == 2) {
            Auth::guard('webmaster')->logout();
            return response()->json([
                'status' => 400,
                'message' => ['email' => 'Your account is banned.']
            ]);
        }

        // Check if account is locked
        if ($webmaster->is_locked) {
            // Auth::guard('webmaster')->logout();
            return response()->json([
                'status' => 403,
                'message' => 'This account has been locked due to suspicious activity,check your email to rest it!'
            ]);
        }

        //generate security token
        $webmaster->security_token = Str::random(60);
        $webmaster->save();
        // Check if 2FA is enabled
        if ($webmaster->two_factor_enabled) {
            // Store the user ID in session temporarily for 2FA verification
            session(['2fa:user:id' => $webmaster->id]);
            if ($webmaster->two_factor_type === 'otp') {
                // Generate and send OTP via email
                $otp = mt_rand(100000, 999999);  // 6-digit numeric OTP
                $webmaster->otp = bcrypt($otp);
                $webmaster->otp_expires_at = now()->addMinutes(10);
                $webmaster->save();

                // Send OTP via email
                try {
                    Mail::to($webmaster->email)->send(new OtpMail($otp));
                } catch (\Exception $e) {
                    \Log::error('Failed to send OTP email to ' . $webmaster->email, ['error' => $e->getMessage()]);

                    return response()->json([
                        'status' => 500,
                        'message' => ['email' => 'Failed to send OTP email. Please try again.']
                    ]);
                }

                // Redirect to OTP form
                return response()->json([
                    'status' => 200,
                    'url' => route('webmaster.otp.form')
                ]);
            } elseif ($webmaster->two_factor_type === 'authenticator') {
                // Redirect to the authenticator code verification form
                return response()->json([
                    'status' => 200,
                    'url' => route('webmaster.2fa.form')
                ]);
            }
        }


        // Normal login if 2FA is not enabled
        Auth::guard('webmaster')->login($webmaster);

        //send login notification to user
        register_shutdown_function(function () use ($webmaster) {
            event(new LoginEvent('webmaster', $webmaster, false));
        });
        return response()->json([
            'status' => 200,
            'url' => redirect()->intended(route('webmaster.dashboard'))->getTargetUrl()
        ]);
    }

    public function showOtpForm()
    {
        $page_title = 'Enter OTP';
        return view('webmaster.auth.otp', compact('page_title'));
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|string'
            ]);

            if ($validator->fails()) {
                Log::warning('OTP validation failed', [
                    'errors' => $validator->errors()->all()
                ]);

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $webmaster = StaffMember::where('otp', Hash::check($request->otp, 'otp'))
                ->where('otp_expires_at', '>', now())
                ->first();

            if (!$webmaster) {
                Log::warning('Invalid or expired OTP attempt', [
                    'entered_otp' => $request->otp
                ]);

                return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
            }

            // Log the user in and clear OTP
            Auth::guard('webmaster')->login($webmaster);

            $webmaster->otp = null;
            $webmaster->otp_expires_at = null;
            $webmaster->save();

            Log::info('User successfully logged in via OTP', [
                'webmaster_id' => $webmaster->id
            ]);

            // Fire the login event after shutdown to ensure all processing is done
            register_shutdown_function(function () use ($webmaster) {
                event(new LoginEvent('webmaster', $webmaster, false));
            });

            return redirect()->intended(route('webmaster.dashboard'));
        } catch (Exception $e) {
            // Log any real unexpected errors
            Log::error('An error occurred during OTP verification', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['error' => 'An error occurred during OTP verification. Please try again later.']);
        }
    }

    public function show2faForm()
    {
        $page_title = 'Enter 2FA Code';
        return view('webmaster.auth.2fa', compact('page_title'));
    }

    public function verify2fa(Request $request)
    {
        // Validate the 2FA code
        $validator = Validator::make($request->all(), [
            'fa_code' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $google2fa = app(Google2FA::class);

        // Retrieve the staff member from the session
        $userId = session('2fa:user:id');
        $staffMember = StaffMember::find($userId);

        if (!$staffMember) {
            return redirect()->back()->withErrors(['fa_code' => 'User not found.']);
        }

        // Verify the 2FA code
        $valid = $google2fa->verifyKey($staffMember->google2fa_secret, $request->input('fa_code'), 3);

        if (!$valid) {
            return redirect()->back()->withErrors(['fa_code' => 'Invalid 2FA code.'])->withInput();
        }

        // Clear the 2FA session data
        session()->forget('2fa:user:id');

        // Log in the user
        Auth::guard('webmaster')->login($staffMember);
        register_shutdown_function(function () use ($staffMember) {
            event(new LoginEvent('webmaster', $staffMember, false));
        });

        // Redirect to intended URL or default to dashboard
        return redirect()->intended(route('webmaster.dashboard'));
    }



    public function enableTwoFactorAuth(Request $request)
    {
        try {
            /** @var StaffMember $staffMember */
            $staffMember = Auth::guard('webmaster')->user();

            if ($staffMember->two_factor_enabled && $staffMember->two_factor_type === $request->input('fa_method')) {
                // Log the case where 2FA is already enabled
                Log::info('2FA already enabled for user', [
                    'staff_member_id' => $staffMember->id,
                    'method' => $staffMember->two_factor_type
                ]);

                // Return JSON response if 2FA is already enabled
                return response()->json([
                    'status' => 'error',
                    'message' => 'Two-factor authentication is already enabled.'
                ], 400);
            }

            // If method is by OTP
            if ($request->input('fa_method') === 'otp') {
                $staffMember->update([
                    'google2fa_secret' => null,
                    'two_factor_enabled' => true,
                    'two_factor_type' => $request->input('fa_method'),
                ]);

                Log::info('2FA (OTP) enabled for user', [
                    'staff_member_id' => $staffMember->id
                ]);

                return response()->json(['success' => true], 200);
            }

            $google2fa = app(Google2FA::class);

            // Generate a secret key for Google Authenticator
            $secret = $google2fa->generateSecretKey();

            $staffMember->update([
                'google2fa_secret' => $secret,
                'two_factor_enabled' => true,
                'two_factor_type' => $request->input('fa_method'),
            ]);

            if ($staffMember->two_factor_type === 'authenticator') {
                // Generate a QR code for the authenticator app
                $QR_Image = QrCode::size(200)->generate($google2fa->getQRCodeUrl(
                    config('app.name'),
                    $staffMember->email,
                    $secret
                ));

                Log::info('2FA (authenticator) enabled and QR code generated for user', [
                    'staff_member_id' => $staffMember->id
                ]);

                $view = view('webmaster.auth.2fa_setup', compact('QR_Image', 'secret'))->render();
                return response()->json(['html' => $view]);
            }

            Log::info('2FA enabled for user', [
                'staff_member_id' => $staffMember->id,
                'method' => $staffMember->two_factor_type
            ]);

            // Return JSON response when 2FA is successfully enabled
            return response()->json(['data' => 'Two-factor authentication enabled']);
        } catch (Exception $e) {
            // Log the actual error that occurred
            Log::error('An error occurred during enabling 2FA', [
                'staff_member_id' => isset($staffMember) ? $staffMember->id : null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while enabling two-factor authentication. Please try again later.'
            ], 500);
        }
    }


    public function disableTwoFactorAuth()
    {
        /** @var StaffMember $staffMember */
        $staffMember = Auth::guard('webmaster')->user();

        $staffMember->update([
            'google2fa_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_type' => null,
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return response()->json(['success' => true, 200]);
    }
    public function secureAccount($token)
    {
        $staff = StaffMember::where('security_token', $token)->firstorFail();

        //lock account staff account
        $staff->is_locked = true;
        $staff->save();

        // Log out of all sessions to ensure security
        // Auth::logoutOtherDevices($staff->password);

        return view('webmaster.auth.resetPassword', compact('staff'));
    }
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Update the user's password and unlock account
        $staff = StaffMember::find($id);
        $staff->password = Hash::make($request->password);
        $staff->is_locked = false;
        $staff->security_token = null;
        $staff->save();

        // Log out the user after password change
        // Auth::guard('webmaster')->logout();
        return redirect()->route('webmaster.login')->with('success', 'Password reset successfully. Your account has been unlocked.');
    }
    /**
     * This function counts user login attempts and it will lock the account
     * should the attempts exceed 3 with wrong password
     *
     * @param string $email
     * @return void
     */
    public function countUserLoginAttempts(string $email)
    {
        $user = StaffMember::where('email', $email)->first();

        if ($user) {
            $user->login_attempts += 1;
            $user->save();

            // Notify the user when they have made 3 incorrect attempts.
            if ($user->login_attempts === 3) {
                // Send email notification to user about suspicious activity
                // and inform them that the account will be locked if one more incorrect attempt is made.
                //     register_shutdown_function(function () use ($user) {

                //   });

            }

            // Lock account if login attempts exceed 3.
            if ($user->login_attempts > 3) {
                $user->is_locked = true;
                $user->save();

                // send user email to reset password
                //send login notification to user
                register_shutdown_function(function () use ($user) {
                    // event(new LoginAttemptsExceeded($user));
                    event(new LoginEvent('webmaster', $user, false));
                });
                return response()->json([
                    'status' => 403,
                    'message' => 'This account has been locked due to suspicious activity,check your email to rest it!'
                ]);
            }

            // Return a generic incorrect password message
            return response()->json([
                'status' => 400,
                'message' => ['password' => 'Incorrect password.']
            ]);
        }
    }
    /**
     * The function checks whether the number of times user attempted to log into
     * Account exceeds 3 given that they have entered a correct password
     *
     * @param string $email
     * @return void
     */
    public function userAttemptsExceedAllowable(string $email)
    {
        $user = StaffMember::where('email', $email)->first();
        if ($user) {
            $attempts = $user->login_attempts;
            if ($attempts > 3) {
                //send user email to rest password
                register_shutdown_function(function () use ($user) {
                    event(new LoginEvent('webmaster', $user, false));
                });
                return response()->json([
                    'status' => 403,
                    'message' => 'This account has been locked due to suspicious activity,check your email to rest it!'
                ]);
            }
        }
    }
}
