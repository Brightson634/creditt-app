<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Loan;
use App\Models\Saving;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\StaffMember;
use  App\Models\LoanPayment;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\expenseCategory;
use Khill\Lavacharts\Lavacharts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\WebmasterNotification;
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
    //   if (!Auth::guard('webmaster')->user()->can('approve loans')) {
    //     abort(403, 'Unauthorized action.');
    // }

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) 
      as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount)
       as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) 
       as penalty_amount,created_at as date')->first();

       $monthlyLoanData = Loan::selectRaw('
       DATE_FORMAT(created_at, "%Y-%m") as date,
       SUM(principal_amount) as principal_amount,
       SUM(interest_amount) as interest_amount,
       SUM(repayment_amount) as loan_amount,
       SUM(repaid_amount) as repaid_amount,
       SUM(balance_amount) as balance_amount,
       SUM(fees_total) as fees_total,
       SUM(penalty_amount) as penalty_amount
   ')
   ->groupBy('date')
   ->get();
   
   

      $pendingLoans=Loan::where('status',0)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
      $reviewedLoans=Loan::where('status',1)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
      $approvedLoans=Loan::where('status',2)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
      $rejectedLoans=Loan::where('status',3)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->first();
      //   dd($investmentdata);
      $recentTransaction = LoanPayment::query()->latest()->limit(4)->get();
      $loanTransaction = Loan::query()->latest()->limit(5)->get();
      //  dd($loanTransaction);
      $expense = Expense::selectRaw('SUM(amount) as amount')->first();
      $expenseCategory = Expense::selectRaw('name,category_id,SUM(amount) as amount')->groupBy('category_id')->get();
    //   dd($expenseCategory);
      $interest = $loandata['interest_amount'];
      $revenueData = [
        'Loan Interest'=>$interest,
      ];

        $loanOverViewData=[
            'Loans Issued'=> $loandata['principal_amount']?:0,
            'Loans Repaid'=> $loandata['repaid_amount']?:0,
            'Loans Due' =>($loandata['principal_amount']-$loandata['repaid_amount'])?:0,
            // 'Loans Pending'=>$pendingLoans['principal_amount']?:0,
            // 'Loans Reviewed'=>$reviewedLoans['principal_amount']?:0,
            // 'Loans Approved'=>$approvedLoans['principal_amount']?:0,
            // 'Loans Rejected'=>$rejectedLoans['principal_amount']?:0
        ];

        $statisticsData=[
            'Total Accounts'=>$accountdata->total_accounts,
            'Total Transactions'=>$savingdata->total_savings,
            'Banked Amount'=>0
        ];


      $expenseCategoryData=[];
    //   return response()->json($expenseCategory);
      foreach($expenseCategory as $row)
      {
            $expenseCategoryData[$row->name]=$row['amount'];
      }
      return view('webmaster.profile.dashboard',
      compact('page_title','expense','loanTransaction','recentTransaction',
      'loandata','statisticsData','revenueData','accountdata', 
      'savingdata', 'investmentdata',
      'loanOverViewData','expenseCategoryData','monthlyLoanData'));
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
