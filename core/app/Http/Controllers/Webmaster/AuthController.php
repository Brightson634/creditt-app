<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Webmaster;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

              if(webmaster()->status == 2){
                auth()->guard('webmaster')->logout();
                return response()->json([
                  'status' => 400,
                  'message' => [ 'email' => 'Sorry! You are banned to access the system.' ]
               ]);
              }
              $notify[] = ['success', 'Login successfully!'];
              session()->flash('notify', $notify); 
               return response()->json([
                  'status' => 200,
                  'url' => route('webmaster.dashboard')
               ]);

            } else {
               return response()->json([
                  'status' => 400,
                  'message' => [ 'password' => 'Sorry! the credentials do not match' ]
               ]);
            }
         }else {
            return response()->json([
               'status' => 400,
               'message' => [ 'password' => 'The password is wrong' ]
            ]);
         }
      }else{
         return response()->json([
            'status' => 400,
            'message' => [ 'email' => 'The email is wrong' ]
         ]);
      }
   }

}