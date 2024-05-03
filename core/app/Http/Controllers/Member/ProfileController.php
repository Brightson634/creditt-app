<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Models\MemberNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
   {
     $this->middleware('auth:member');
   }

   public function account()
   {
      $page_title = 'My Account';
      $member = Auth::guard('member')->user();
      return view('member.profile.account', compact('page_title', 'member'));
   }
    
   public function profile()
   {
      $page_title = 'My Profile';
      $member = Auth::guard('member')->user();
      return view('member.profile.profile', compact('page_title', 'member'));
   }

   public function profilePhoto(Request $request) 
   {
      if ($request->hasFile('photo')) {
         $temp_name = $request->file('photo');
         $photo = slugCreate(member()->name) . '_photo_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/members', $photo);
         if (member()->photo) {
            @unlink('assets/uploads/members/'.member()->photo);
         }
      }

      Member::where('id', member()->id)->update([ 
         'photo' => $photo 
      ]);

      $notify[] = ['success', 'profile Photo updated successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);

   }

   public function profileUpdate(Request $request)
   {

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'telephone' => 'required',
        'address' => 'required'
      ], [
        'name.required'       => 'The name is required.',
        'email.required'      => 'The email is required',
        'telephone.required'  => 'The telephone is required',
        'address.required'    => 'The address is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      Member::where('id', member()->id)->update([ 
          'name'      => $request->name,
          'username'  => usernameGenerate($request->email),
          'email'     => $request->email,
          'telephone' => $request->telephone,
          'address'   => $request->address
      ]);

      $notify[] = ['success', 'Profile information updated successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);
  }

  public function updatePassword(Request $request) 
  {
      $validator = Validator::make($request->all(), [
         'old_password'  => 'required|min:8',
         'new_password'  => 'required|min:8',
         'confirm_password' => 'required|min:8|same:new_password'
      ], [
         'confirm_password.same' => 'passwords do not match',
         'confirm_password.required' => 'confirm password is required'
      ]);

      if($validator->fails()){
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      if (!Hash::check($request->old_password, member()->password)) {
         return response()->json([
            'status' => 400,
            'message' => [ 'old_password' => 'The old password is wrong' ]
         ]);
      }

      Member::where('id', member()->id)->update([ 
         'password' => Hash::make($request->new_password)
      ]);

      $notify[] = ['success', 'Password changed successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200,
         'url' => route('member.logout')
      ]);
  }

   public function logout()
   {
      //Auth::guard('member')->logout();
      $auth = Auth::guard('member');
       $auth->logout();

      $notify[] = ['success', 'Logout successfully!'];
      session()->flash('notify', $notify);
        
      return redirect('/member');
   }
}
