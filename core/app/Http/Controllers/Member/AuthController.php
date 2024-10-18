<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:member', ['except' => ['logout']]);
    }

    public function loginForm()
    {
      $page_title = 'Welcome to Member Panel';
      return view('member.auth.login', compact('page_title'));
    }

    public function login(Request $request) 
   {
      $validator = Validator::make($request->all(), [
         'member_no'   => 'required',
         'password'  => 'required|min:8'
      ], [
        'member_no.required'  => 'The member ID is required',
        'password.required'       => 'The password is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $member = Member::where('member_no',$request->member_no)->first();

      if (!empty($member)) {
         
         if (Hash::check($request->password, $member->password)) {
            if (Auth::guard('member')->attempt(['member_no' => $request->member_no, 'password' => $request->password], $request->remember)) {
              if(member()->status == 2){
                auth()->guard('member')->logout();
                return response()->json([
                  'status' => 400,
                  'message' => [ 'member_no' => 'Sorry! You are banned to access the system.' ]
               ]);
              }

              $notify[] = ['success', 'Login successfully!'];
              session()->flash('notify', $notify); 
               return response()->json([
                  'status' => 200,
                  'url' =>redirect()->intended(route('member.dashboard',['id' => $member->member_no]))->getTargetUrl()
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
            'message' => [ 'member_no' => 'The provided ID is found' ]
         ]);
      }
   }
}