<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\MemberNotification;
use App\Models\Statement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:member');
   }
    
   public function index() 
   {
      $page_title = 'Dashboard';
      $setting = Setting::first();
      //$data = MemberSaving::where('member_id', member()->id)->where('savingyear_id', $setting->savingyear)->first();
      $transactions = Statement::where('member_id', member()->id)->orderBy('id','DESC')->get();
      return view('member.profile.dashboard', compact('page_title', 'transactions'));
   }

   public function notifications() 
   {
      $page_title = 'Notifications';
      $notifications = MemberNotification::orderBy('id','DESC')->get();
      return view('member.profile.notifications',compact('page_title', 'notifications'));
   }


   public function notificationread($id)
   {
      $notification = AdminNotification::findOrFail($id);
      $notification->notification_read_status = 1;
      $notification->save();
      return redirect($notification->notification_url);
   }
}
