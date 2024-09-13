<?php

namespace App\Http\Controllers\Webmaster;

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
            return response()->json([
                'status' => 400,
                'message' => ['password' => 'Incorrect password.']
            ]);
        }

        if ($webmaster->status == 2) {
            Auth::guard('webmaster')->logout();
            return response()->json([
                'status' => 400,
                'message' => ['email' => 'Your account is banned.']
            ]);
        }



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
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $webmaster = StaffMember::where('otp', Hash::check($request->otp, 'otp'))
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$webmaster) {
            return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Login user and clear OTP
        Auth::guard('webmaster')->login($webmaster);
        $webmaster->otp = null;
        $webmaster->otp_expires_at = null;
        $webmaster->save();

        return redirect()->intended(route('webmaster.dashboard'));
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
    
        // Redirect to intended URL or default to dashboard
        return redirect()->intended(route('webmaster.dashboard'));
    }
    
    public function enableTwoFactorAuth(Request $request)
    {
        /** @var StaffMember $staffMember */
        $staffMember = Auth::guard('webmaster')->user();
       
        if($staffMember->two_factor_enabled & $staffMember->two_factor_type ===$request->input('fa_method') ) {
            // Return JSON response if 2FA is already enabled
            return response()->json([
                'status' => 'error',
                'message' => 'Two-factor authentication is already enabled.'
            ], 400);
        }

        //if method is by otp
        if($request->input('fa_method') === 'otp')
        {
            $staffMember->update([
                'google2fa_secret' => null,
                'two_factor_enabled' => true,
                'two_factor_type' => $request->input('fa_method'),
            ]);

            return response()->json(['success'=>true,200]);
    
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
            $QR_Image = \QrCode::size(200)->generate($google2fa->getQRCodeUrl(
                config('app.name'),
                $staffMember->email,
                $secret
            ));


            $view = view('webmaster.auth.2fa_setup', compact('QR_Image', 'secret'))->render();
            return response()->json(['html' => $view]);
        }

        // return redirect()->back()->with('status', 'Two-factor authentication enabled.');
        return response()->json(['data' => 'Two-factor authentication enabled']);
    }

    public function disableTwoFactorAuth()
    {
          /** @var StaffMember $staffMember */
        $staffMember = Auth::guard('webmaster')->user();

        $staffMember->update([
            'google2fa_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_type' => null,
            'otp'=>null,
            'otp_expires_at'=>null
        ]);

        return response()->json(['success' =>true,200]);
    }
}
