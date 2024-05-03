<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Loan;
use App\Models\MemberAccount;
use App\Models\Saving;
use App\Models\Investment;

use App\Models\WebmasterNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
   
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
    
   public function index() 
   {
      $page_title = 'Dashboard';

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount) as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) as penalty_amount')->first();

      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->first();

      return view('webmaster.profile.dashboard', compact('page_title', 'loandata', 'accountdata', 'savingdata', 'investmentdata'));
   }

   public function notifications() 
   {
      $notifications = WebmasterNotification::orderBy('id','desc')->get();
      $page_title = 'Notifications';
      return view('webmaster.profile.notifications',compact('page_title', 'notifications'));
   }


   public function notificationread($id)
   {
      $notification = AdminNotification::findOrFail($id);
      $notification->notification_read_status = 1;
      $notification->save();
      return redirect($notification->notification_url);
   }

}