<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Webmaster;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:webmaster', ['except' => ['logout']]);
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

        // Generate and store OTP
        $otp = Str::random(6);
        $webmaster->otp = $otp;
        $webmaster->otp_expires_at = now()->addMinutes(10);
        $webmaster->save();

        // Send OTP via email
        try {
            Mail::to($webmaster->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => ['email' => 'Failed to send OTP email. Please try again.']
            ]);
        }

        return response()->json([
            'status' => 200,
            'url' => route('webmaster.otp.form')
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

        $webmaster = StaffMember::where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$webmaster) {
            // return response()->json([
            //     'status' => 400,
            //     'message' => ['otp' => 'Invalid or expired OTP.']
            // ]);
            return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Login user and clear OTP
        Auth::guard('webmaster')->login($webmaster);
        $webmaster->otp = null;
        $webmaster->otp_expires_at = null;
        $webmaster->save();

        return redirect()->intended(route('webmaster.dashboard'));
        // return response()->json([
        //     'status' => 200,
        //     'url' => redirect()->intended(route('webmaster.dashboard'))->getTargetUrl()
        // ]);
    }

    // public function enableTwoFactorAuth(Request $request)
    // {
    //     /** @var StaffMember $staffMember */
    //     $staffMember = Auth::guard('webmaster')->user();

    //     // Check if 2FA is already enabled
    //     if ($staffMember->two_factor_enabled) {
    //         return redirect()->back()->withErrors(['2fa' => 'Two-factor authentication is already enabled.']);
    //     }

    //     // Initialize Google2FA
    //     $google2fa = app(Google2FA::class);

    //     // Generate a secret key for 2FA
    //     $secret = $google2fa->generateSecretKey();

    //     // Store the secret and enable 2FA in the database
    //     $staffMember->update([
    //         'google2fa_secret' => $secret,
    //         'two_factor_enabled' => true,
    //     ]);

    //     // Generate a QR code image using the simple-qrcode package
    //     $QR_Image = QrCode::size(200)->generate($google2fa->getQRCodeUrl(
    //         config('app.name'),
    //         $staffMember->email,
    //         $secret
    //     ));

    //     // Return the 2FA setup view with the QR code and secret
    //     return view('webmaster.auth.2fa_setup', compact('QR_Image', 'secret'));
    // }
}
