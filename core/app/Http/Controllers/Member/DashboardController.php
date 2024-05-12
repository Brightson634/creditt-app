<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Loan;
use App\Models\Investment;
use App\Models\Statement;
use App\Models\LoanPayment;
use App\Models\MemberAccount;
use App\Models\MemberNotification;
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
                                                               
      $savings = Saving::where('member_id', member()->id)->get();
      $accounts = MemberAccount::where('member_id', member()->id);
      $loans = Loan::where('member_id', member()->id)->get();
      $repayments = LoanPayment::where('member_id', member()->id)->orderBy('id','DESC')->get();
      // dd($accounts);
      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->where('member_id', member()->id)->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->where('member_id', $member->id)->first();

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount) as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) as penalty_amount')->where('member_id', member()->id)->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->where('investor_id', member()->id)->first();


      return view('member.profile.dashboard', compact('page_title', 'transactions','savingdata','accountdata','loandata','investmentdata'));
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
