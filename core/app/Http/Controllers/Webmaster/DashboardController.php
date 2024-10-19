<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Loan;
use App\Models\Saving;
use App\Models\Expense;
use App\Models\Activity;
use App\Models\Investment;
use App\Models\LoanCharge;
use App\Models\StaffMember;
use  App\Models\LoanPayment;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\expenseCategory;
use Khill\Lavacharts\Lavacharts;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\WebmasterNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;


class DashboardController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function index()
  {
    $page_title = 'Dashboard';
    if (!Auth::guard('webmaster')->user()->can('view_main_dashboard')) {
      $page_title = 'Dashboard Calendar';
      return redirect()->route('webmaster.calendar.view')->with('message', 'dashboard');
    }

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

    $activityStreams = Activity::latest()->take(20)->get();

    // Extract user IDs for staff members
    $userIds = $activityStreams->pluck('user_id')->filter()->unique();

    // Fetch staff members
    $staffMembers = DB::table('staff_members')
      ->whereIn('id', $userIds)
      ->get(['id', 'fname', 'lname', 'title']);

    // Map staff members
    $staffNameMap = $staffMembers->mapWithKeys(function ($staff) {
      return [$staff->id => $staff->title . '. ' . ucfirst(strtolower($staff->fname)) . ' ' . ucfirst(strtolower($staff->lname))];
    })->toArray();

    // Fetch members for activities with status 9
    $memberIds = $activityStreams->where('status', 9)->pluck('user_id')->filter()->unique();
    $members = DB::table('members')
      ->whereIn('id', $memberIds)
      ->get(['id', 'fname', 'lname']);

    // Map members
    $memberNameMap = $members->mapWithKeys(function ($member) {
      return [$member->id => ucfirst(strtolower($member->fname)) . ' ' . ucfirst(strtolower($member->lname))];
    })->toArray();
    foreach ($activityStreams as $activity) {
      if ($activity->status == 9) {
        $activity->staffname = $memberNameMap[$activity->user_id] ?? null;
      } else {
        $activity->staffname = $staffNameMap[$activity->user_id] ?? null;
      }
      $activity->formatted_time = $activity->created_at->diffForHumans();
    }


    // return response()->json($activityStreams);



    $pendingLoans = Loan::where('status', 0)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
    $reviewedLoans = Loan::where('status', 1)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
    $approvedLoans = Loan::where('status', 2)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
    $rejectedLoans = Loan::where('status', 3)->selectRaw('SUM(principal_amount) as principal_amount ')->first();
    $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();

    $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();

    $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->first();
    //   dd($investmentdata);
    $recentTransaction = LoanPayment::query()->latest()->limit(4)->get();
    $loanTransaction = Loan::query()->latest()->limit(5)->get();
    //  dd($loanTransaction);
    $expense = Expense::selectRaw('SUM(amount) as amount')->first();
    $expenseCategory = Expense::selectRaw('name,category_id,SUM(amount) as amount')->groupBy('category_id')->get();

    //loan charges
    $loanCharges = LoanCharge::sum('amount');
    //loan interest
    $interest = $loandata['interest_amount'];
    //loan charges
    $revenueData = [
      'Loan_interest' => $interest,
      'Loan_charges' => $loanCharges
    ];

    // return response()->json($revenueData);

    $loanOverViewData = [
      'Loans Issued' => $loandata['principal_amount'] ?: 0,
      'Loans Repaid' => $loandata['repaid_amount'] ?: 0,
      'Loans Due' => ($loandata['principal_amount'] - $loandata['repaid_amount']) ?: 0,
      // 'Loans Pending'=>$pendingLoans['principal_amount']?:0,
      // 'Loans Reviewed'=>$reviewedLoans['principal_amount']?:0,
      // 'Loans Approved'=>$approvedLoans['principal_amount']?:0,
      // 'Loans Rejected'=>$rejectedLoans['principal_amount']?:0
    ];

    $statisticsData = [
      'Total Accounts' => $accountdata->total_accounts,
      'Total Transactions' => $savingdata->total_savings,
      'Banked Amount' => 0
    ];


    $expenseCategoryData = [];

    foreach ($expenseCategory as $row) {
      $expenseCategoryData[$row->name] = $row['amount'];
    }

    // return response()->json($loanTransaction);
    return view(
      'webmaster.profile.dashboard',
      compact(
        'page_title',
        'expense',
        'loanTransaction',
        'recentTransaction',
        'loandata',
        'statisticsData',
        'revenueData',
        'accountdata',
        'savingdata',
        'investmentdata',
        'loanOverViewData',
        'expenseCategoryData',
        'monthlyLoanData',
        'activityStreams'
      )
    );
  }

  public function getFilteredData(Request $request)
  {
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    // Fetch and filter data based on date range
    $statisticsData = $this->getStatisticsData($startDate, $endDate);
    $monthlyLoanData = $this->getMonthlyLoanData($startDate, $endDate);
    $expenseCategoryData = $this->getExpenseCategoryData($startDate, $endDate);
    $revenueData = $this->getRevenueData($startDate, $endDate);

    return response()->json([
      'statisticsData' => $statisticsData,
      'monthlyLoanData' => $monthlyLoanData,
      'expenseCategoryData' => $expenseCategoryData,
      'revenueData' => $revenueData
    ]);
  }

  public function getStatisticsData($startDate, $endDate)
  {
    //Filter statistics data by date range
    $accountdataQuery = MemberAccount::query();
    $savingdataQuery = Saving::query();
    if ($startDate && $endDate) {
      $accountdataQuery->whereBetween('created_at', [$startDate, $endDate]);
      $savingdataQuery->whereBetween('created_at', [$startDate, $endDate]);
      $accountdata = $accountdataQuery->selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();
      $savingdata = $savingdataQuery->selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();
    } else {
      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, 
      SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();
      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();
    }

    $statisticsData = [
      'Total Accounts' => $accountdata->total_accounts,
      'Total Transactions' => $savingdata->total_savings,
      'Banked Amount' => 0
    ];
    // return $startDate ; 2024-09-11 2024-09-16 
    return $statisticsData;
  }
  public function getMonthlyLoanData($startDate, $endDate)
  {
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

    return $monthlyLoanData;
  }
  public function getExpenseCategoryData($startDate, $endDate)
  {
    $expenseQuery = Expense::query();
    if ($startDate && $endDate) {
      $expenseQuery->whereBetween('created_at', [$startDate, $endDate]);
      $expenseCategory = $expenseQuery->selectRaw('name,category_id,SUM(amount) as amount')->groupBy('category_id')->get();
    } else {
      $expenseCategory = Expense::selectRaw('name,category_id,SUM(amount) as amount')->groupBy('category_id')->get();
    }
    $expenseCategoryData = [];

    foreach ($expenseCategory as $row) {
      $expenseCategoryData[$row->name] = $row['amount'];
    }

    return $expenseCategoryData;
  }

  public function getRevenueData($startDate, $endDate)
  {
    $loandataQuery = Loan::query();
    $loanchargesQuery = LoanCharge::query();
    if ($startDate && $endDate) {
      $loandataQuery->whereBetween('created_at', [$startDate, $endDate]);
      $loanchargesQuery->whereBetween('created_at', [$startDate, $endDate]);
      $loandata = $loandataQuery->selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) 
      as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount)
       as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) 
       as penalty_amount,created_at as date')->first();
      $loanCharges = $loanchargesQuery->sum('amount');
    } else {
      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) 
      as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount)
       as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) 
       as penalty_amount,created_at as date')->first();
      //loan charges
      $loanCharges = LoanCharge::sum('amount');
    }
    //loan interest
    $interest = $loandata['interest_amount'];
    //loan charges
    $revenueData = [
      'Loan_interest' => $interest,
      'Loan_charges' => $loanCharges
    ];
    return $revenueData;
  }




  public function notifications()
  {
    $notifications = WebmasterNotification::orderBy('id', 'desc')->get();
    $page_title = 'Notifications';
    return view('webmaster.profile.notifications', compact('page_title', 'notifications'));
  }


  public function notificationread($id)
  {
    $notification = AdminNotification::findOrFail($id);
    $notification->notification_read_status = 1;
    $notification->save();
    return redirect($notification->notification_url);
  }



  public function testVerification(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'fa_code' => 'required|numeric'
      ]);

      if ($validator->fails()) {
        // Log the validation error
        Log::warning('2FA code validation failed', [
          'errors' => $validator->errors()->all()
        ]);

        return response()->json([
          'success' => false,
          'error' => 'Invalid 2FA code. Please try again.',
          'errors' => $validator->errors()
        ], 422);
      }

      $google2fa = app(Google2FA::class);
      /** @var StaffMember $staffMember */
      $staffMember = Auth::guard('webmaster')->user();

      $valid = $google2fa->verifyKey($staffMember->google2fa_secret, $request->input('fa_code'), 3);

      if (!$valid) {
        // Log the invalid 2FA code attempt
        Log::warning('Invalid 2FA code entered', [
          'staff_member_id' => $staffMember->id,
          'entered_code' => $request->input('fa_code')
        ]);

        return response()->json([
          'success' => false,
          'error' => 'Invalid 2FA code.'
        ], 400);
      }

      $staffMember->update([
        'google2fa_secret' => $request->input('secret'),
        'two_factor_enabled' => true,
        'two_factor_type' => 'authenticator',
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Two-factor Authentication has been setup!'
      ], 200);
    } catch (Exception $e) {
      // Log the actual error that occurred
      Log::error('An error occurred during 2FA setup', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);

      return response()->json([
        'success' => false,
        'error' => 'An error occurred while setting up 2FA. Please try again later.'
      ], 500);
    }
  }

  public function calendar()
  {
    return view('webmaster.profile.calendartemp');
  }
}
