<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Loan;
use  App\Models\LoanPayment;
use App\Models\MemberAccount;
use App\Models\expenseCategory;
use App\Models\Saving;
use App\Models\Investment;
use App\Models\Expense;
use App\Models\WebmasterNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Khill\Lavacharts\Lavacharts;


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
      // dd($loandata);
      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->first();
      //   dd($investmentdata);
      $recentTransaction = LoanPayment::query()->latest()->limit(10)->get();
      $loanTransaction = Loan::query()->latest()->limit(5)->get();
      //  dd($loanTransaction);
      $expense = Expense::selectRaw('SUM(amount) as amount')->first();
      $expenseCategory = ExpenseCategory::all();
      // dd($expenseCategory);

      $lava = new Lavacharts;
      $interet = $loandata['interest_amount']*100;
      $fees = $loandata['fees_total']*100;
      $percentage = ($loandata['interest_amount'] / $loandata['fees_total']) * 100;
      $data1 = $lava->DataTable();
      $data1->addStringColumn('Reasons')
               ->addNumberColumn('Percent')
               ->addRow(['Loan Interest', $interet])
               ->addRow(['Loan pernalty', $fees])
               ->addRow(['Percentage', $percentage]);

      $lava->DonutChart('LOANS', $data1, [
         'title' => '',  
             'legend' => [
               'position' => 'top'
           ]
      ]);


        $data2 = $lava->DataTable();
        $loanDue = $loandata->principal_amount - $loandata->repaid_amount;
      //   dd($loanDue);
        $data2->addStringColumn('Reasons')
            ->addNumberColumn('')
            ->addRow(['Loan Issued', $loandata['principal_amount']])
            ->addRow(['Loan Repaid', $loandata['repaid_amount']])
            ->addRow(['Loan Due', $loanDue])
            ->addRow(['Revenue', 0]);
           

        $lava->ColumnChart('IMDB', $data2, [
            'title' => '', 
         //    'legend' => [
         //       'position' => 'top'
         //   ]
        ]);
        $data3 = $lava->DataTable();
        $data3->addStringColumn('Reasons')
            ->addNumberColumn('Accounts')
            ->addNumberColumn('Transactions')
            ->addNumberColumn('Banks')
            ->addRow(['Total Accounts','Accounts', $accountdata->total_accounts])
            ->addRow(['Total Transactions','Transactions', $savingdata->total_savings])
            ->addRow(['Banked Amount','Banks', 0]);
            
           

        $lava->LineChart('STATISTIC', $data3, [
         'title' => '', 
         'curveType' => 'function',
    'lineWidth' => 2,
    'dataOpacity' => 0.3,
    'pointSize' => 5,
    'pointShape' => 'circle',
         'colors' => ['#ff0000', '#0000ff','#0000EE'],
         'legend' => [
            'position' => 'bottom',]
     ]);
        
        $population = $lava->DataTable();
        $population->addDateColumn('Year')
           ->addNumberColumn('Number of People')
           ->addRow(['2006', 623452])
           ->addRow(['2007', 685034])
           ->addRow(['2008', 716845])
           ->addRow(['2009', 757254])
           ->addRow(['2010', 778034])
           ->addRow(['2011', 792353])
           ->addRow(['2012', 839657])
           ->addRow(['2013', 842367])
           ->addRow(['2014', 873490]);

      $lava->AreaChart('Population', $population, [
         'title' => '',
         // 'legend' => [
         //    'position' => 'in'
         // ]
      ]);


      $data4 = $lava->DataTable();
      $data4->addStringColumn('Reasons')
            ->addNumberColumn('Percent');
      foreach ($expenseCategory as $row) {
         $data4->addRow([$row['name'],1]);
      }      


      $lava->DonutChart('EXPENSES', $data4, [
         'title' => '',  
             'legend' => [
               'position' => 'top'
           ]
      ]);

      
      return view('webmaster.profile.dashboard', compact('page_title','expense','loanTransaction','recentTransaction','loandata','population','lava','data3','data4','data1','data2' ,'accountdata', 'savingdata', 'investmentdata'));
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