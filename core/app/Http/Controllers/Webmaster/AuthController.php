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
         'email'   => 'required|email',
         'password'  => 'required|min:8'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }
      $webmaster = StaffMember::where('email',$request->email)->first();

      if (!empty($webmaster)) {
          if (Hash::check($request->password, $webmaster->password)) {
              if (Auth::guard('webmaster')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

                  if ($webmaster->status == 2) {
                      auth()->guard('webmaster')->logout();
                      return response()->json([
                          'status' => 400,
                          'message' => [ 'email' => 'Sorry! You are banned from accessing the system.' ]
                      ]);
                  }

                  $notify[] = ['success', 'Login successfully!'];
                  session()->flash('notify', $notify);

                  return response()->json([
                      'status' => 200,
                      'url' => redirect()->intended(route('webmaster.dashboard'))->getTargetUrl()
                  ]);

              } else {
                  return response()->json([
                      'status' => 400,
                      'message' => [ 'password' => 'Sorry! the credentials do not match' ]
                  ]);
              }
          } else {
              return response()->json([
                  'status' => 400,
                  'message' => [ 'password' => 'The password is wrong' ]
              ]);
          }
      } else {
          return response()->json([
              'status' => 400,
              'message' => [ 'email' => 'The email is wrong' ]
          ]);
      }
   }

   public function enableTwoFactorAuth(Request $request)
   {
       /** @var StaffMember $staffMember */
       $staffMember = Auth::guard('webmaster')->user();
   
       // Check if 2FA is already enabled
       if ($staffMember->two_factor_enabled) {
           return redirect()->back()->withErrors(['2fa' => 'Two-factor authentication is already enabled.']);
       }
   
       // Initialize Google2FA
       $google2fa = app(Google2FA::class);
   
       // Generate a secret key for 2FA
       $secret = $google2fa->generateSecretKey();
   
       // Store the secret and enable 2FA in the database
       $staffMember->update([
           'google2fa_secret' => $secret,
           'two_factor_enabled' => true,
       ]);
   
       // Generate a QR code image using the simple-qrcode package
       $QR_Image = QrCode::size(200)->generate($google2fa->getQRCodeUrl(
           config('app.name'),
           $staffMember->email,
           $secret
       ));
   
       // Return the 2FA setup view with the QR code and secret
       return view('webmaster.auth.2fa_setup', compact('QR_Image', 'secret'));
   }

}