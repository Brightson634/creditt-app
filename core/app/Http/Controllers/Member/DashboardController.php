<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Statement;
use App\Models\Investment;
use Carbon\CarbonInterval;
use App\Models\AccountType;
use App\Models\GroupMember;
use App\Models\LoanPayment;
use App\Models\MemberEmail;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\MemberContact;
use App\Models\MemberDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MemberNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoanRepaymentSchedule;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:member');
   }

   public function index($member_no)
   {
      $page_title = 'Dashboard';
      $member = Member::where('member_no', $member_no)->first();
      $page_title = 'Member Dashboard: ' . $member_no;
      $savings = Saving::where('member_id', $member->id)->get();
      $accounts = MemberAccount::where('member_id', $member->id)->get();
      $statements = Statement::where('member_id', $member->id)->get();
      $loans = Loan::where('member_id', $member->id)->get();
      $contacts = MemberContact::where('member_id', $member->id)->get();
      $emails = MemberEmail::where('member_id', $member->id)->get();
      $groupmembers = GroupMember::where('member_id', $member->id)->get();
      $documents = MemberDocument::where('member_id', $member->id)->get();
      $repayments = LoanPayment::where('member_id', $member->id)->orderBy('id', 'DESC')->get();

      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->where('member_id', $member->id)->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance, 
      COUNT(id) as total_accounts, accounttype_id, account_no as accNumber')->where('member_id', $member->id)->first();

      $accType = (AccountType::where('id', $accountdata->accounttype_id)->first());
      if ($accType != null) {
         $accountdata->accType = $accType->name;
      }

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount) as balance_amount, 
      SUM(fees_total) as fees_total, SUM(penalty_amount) as penalty_amount')->where('member_id', $member->id)->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->where('investor_id', $member->id)->first();

      return view('member.profile.dashboard', compact('page_title', 'member', 'savings', 'accounts', 'statements', 'loans', 'contacts', 'emails', 'groupmembers', 'documents', 'loandata', 'investmentdata', 'savingdata', 'accountdata', 'repayments'));
   }


   public function notifications()
   {
      $page_title = 'Notifications';
      $notifications = MemberNotification::orderBy('id', 'DESC')->get();
      return view('member.profile.notifications', compact('page_title', 'notifications'));
   }


   public function notificationread($id)
   {
      $notification = AdminNotification::findOrFail($id);
      $notification->notification_read_status = 1;
      $notification->save();
      return redirect($notification->notification_url);
   }

   public function getCalendar()
   {
      $page_title = 'Calendar';
      return view('member.calendar.common_calendar', compact('page_title'));
   }

   public function fetchEvents()
   {
      $repayments = LoanRepaymentSchedule::where('member_id', member()->id)->get();
      $events = $repayments->map(function ($schedule) {
         return [
            'title' => 'Payment Due: ' . number_format($schedule->amount_due, 2, '.', ',') . '(Member: ' . $schedule->member->fname . ' ' . $schedule->member->lname . ')',
            'start' => $schedule->due_date,
         ];
      });
      return response()->json($events);
   }

   public function repaymentScheduleIndex()
   {
      $page_title = 'Repayment Schedule';
      return view('member.loans.repayment',compact('page_title'));
   }

   /**
    * This function is responsible for loan scheduling depending
    *dpending on the interest Method
    * @param Request $request
    * @return void
    */
   public function calculateLoan(Request $request)
   {
      $loan = Loan::where('member_id',member()->id)->first();
      $loanAmount = $loan->disbursment_amount;
      $interestRate = $loan->loanproduct->interest_rate;
      $interestRatePeriod = $loan->loanproduct->duration . 's';
      $loanTermValue = $loan->loan_period;
      $loanTermUnit = $loan->loanproduct->duration . 's';
      $interestMethod = $loan->loan_repayment_method;
      $duration = $loan->loanproduct->duration;
      $repaymentPeriod = ($duration === 'day') ? 'daily' : $duration . 'ly';
      $releaseDate = Carbon::parse($loan->disbursement_date);
      // Disbursement date
      $disbursementDate = Carbon::parse($loan->disbursement_date);

      // Add grace period if it exists
      // if ($loan->grace_period && $loan->grace_period_in) {
      //    $graceInterval = $loan->grace_period;
      //    $graceUnit = $loan->grace_period_in;
      //    // Add grace period to disbursement date
      //    $releaseDate->add($graceInterval, $graceUnit);
      // }



      // Convert the loan term to years for consistency
      $loanTermInYears = $this->convertTermToYears($loanTermValue, $loanTermUnit);

      // Convert the interest rate based on the interest rate period
      $annualInterestRate = $this->convertInterestRateToAnnual($interestRate, $interestRatePeriod);
      // return response()->json([$loanTermInYears,$annualInterestRate]);

      // Initialize the total interest, total repayment, and repayment schedule
      $totalInterest = 0;
      $totalRepayment = 0;
      $repaymentSchedule = [];

      // Calculate based on the selected interest method
      switch ($interestMethod) {
         case 'flat_rate':
            $totalInterest = ($loanAmount * ($annualInterestRate / 100)) * $loanTermInYears;
            $totalRepayment = $loanAmount + $totalInterest;
            $repaymentSchedule = $this->generateFlatRateAmortizationTable($loanAmount, $totalInterest, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $method = 'Flat Rate';
            break;

         case 'reducing_balance_equal_principal':
            $repaymentSchedule = $this->generateReducingBalanceEqualPrincipal($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest')); // Sum of interest for all periods
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Reducing Balance (Equal Principal)';
            break;

         case 'reducing_balance_equal_installment':
            $repaymentSchedule = $this->generateReducingBalanceEqualInstallment($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Reducing Balance (Equal Installment)';
            break;

         case 'interest_only':
            $repaymentSchedule = $this->generateInterestOnlySchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Interest Only';
            break;

         case 'compound_interest':
            $repaymentSchedule = $this->generateCompoundInterestSchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Compound Interest';
            break;

         default:
            throw new \InvalidArgumentException('Invalid interest method');
      }


      // Return result to a view
      $view = view('member.loans.loanscheduler', compact(
         'loanAmount',
         'interestRate',
         'loanTermInYears',
         'totalInterest',
         'totalRepayment',
         'repaymentSchedule',
         'releaseDate',
         'repaymentPeriod',
         'method'
      ))->render();
      return response()->json(['html' => $view, 'status' => 200]);
   }
   //calculate loan pdf
   public function calculateLoanPdf(Request $request)
   {
      $loan = Loan::where('member_id',member()->id)->first();
      $loanAmount = $loan->disbursment_amount;
      $interestRate = $loan->loanproduct->interest_rate;
      $interestRatePeriod = $loan->loanproduct->duration . 's';
      $loanTermValue = $loan->loan_period;
      $loanTermUnit = $loan->loanproduct->duration . 's';
      $interestMethod = $loan->loan_repayment_method;
      $duration = $loan->loanproduct->duration;
      $repaymentPeriod = ($duration === 'day') ? 'daily' : $duration . 'ly';
      $releaseDate = Carbon::parse($loan->disbursement_date);
      // Disbursement date
      $disbursementDate = Carbon::parse($loan->disbursement_date);

      // Add grace period if it exists
      // if ($loan->grace_period && $loan->grace_period_in) {
      //    $graceInterval = $loan->grace_period;
      //    $graceUnit = $loan->grace_period_in;
      //    // Add grace period to disbursement date
      //    $releaseDate->add($graceInterval, $graceUnit);
      // }


      // Convert the loan term to years for consistency
      $loanTermInYears = $this->convertTermToYears($loanTermValue, $loanTermUnit);

      // Convert the interest rate based on the interest rate period
      $annualInterestRate = $this->convertInterestRateToAnnual($interestRate, $interestRatePeriod);

      // Initialize the total interest, total repayment, and repayment schedule
      $totalInterest = 0;
      $totalRepayment = 0;
      $repaymentSchedule = [];

      // Calculate based on the selected interest method
      switch ($interestMethod) {
         case 'flat_rate':
            $totalInterest = ($loanAmount * ($annualInterestRate / 100)) * $loanTermInYears;
            $totalRepayment = $loanAmount + $totalInterest;
            $repaymentSchedule = $this->generateFlatRateAmortizationTable($loanAmount, $totalInterest, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $method = 'Flat Rate';
            break;

         case 'reducing_balance_equal_principal':
            $repaymentSchedule = $this->generateReducingBalanceEqualPrincipal($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest')); // Sum of interest for all periods
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Reducing Balance (Equal Principal)';
            break;

         case 'reducing_balance_equal_installment':
            $repaymentSchedule = $this->generateReducingBalanceEqualInstallment($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Reducing Balance (Equal Installment)';
            break;

         case 'interest_only':
            $repaymentSchedule = $this->generateInterestOnlySchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Interest Only';
            break;

         case 'compound_interest':
            $repaymentSchedule = $this->generateCompoundInterestSchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate);
            $totalInterest = array_sum(array_column($repaymentSchedule, 'interest'));
            $totalRepayment = $loanAmount + $totalInterest;
            $method = 'Compound Interest';
            break;

         default:
            throw new \InvalidArgumentException('Invalid interest method');
      }

      // Return result to a view
      $view = view('member.loans.loanschedulerpdf', compact(
         'loanAmount',
         'interestRate',
         'loanTermInYears',
         'totalInterest',
         'totalRepayment',
         'repaymentSchedule',
         'releaseDate',
         'repaymentPeriod',
         'method'
      ))->render();

      //Generate the PDF from the HTML
      $pdf = Pdf::loadHTML($view);

      // Set the content type and headers for the PDF download
      return response($pdf->output())
         ->header('Content-Type', 'application/pdf')
         ->header('Content-Disposition', 'attachment; filename="Loan_Schedule.pdf"')
         ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
         ->header('Pragma', 'no-cache')
         ->header('Expires', '0');
      // return response()->json(['html' => $view, 'status' => 200]);
   }
   private function convertInterestRateToAnnual($interestRate, $interestRatePeriod)
   {
      switch ($interestRatePeriod) {
         case 'years':
            return $interestRate; // Already annual
         case 'months':
            return $interestRate * 12; // Convert monthly to annual
         case 'weeks':
            return $interestRate * 52; // Convert weekly to annual
         case 'days':
            return $interestRate * 365; // Convert daily to annual
         default:
            throw new \InvalidArgumentException('Invalid interest rate period');
      }
   }
   private function convertTermToYears($termValue, $termUnit)
   {
      switch ($termUnit) {
         case 'years':
            return $termValue;
         case 'months':
            return $termValue / 12;
         case 'weeks':
            return $termValue / 52;
         case 'days':
            return $termValue / 365;
         default:
            return 0;
      }
   }

   /**
    * Calculate the number of repayment periods based on loan term and repayment period.
    *
    * @param float $loanTermInYears
    * @param string $repaymentPeriod
    * @return int
    */
   private function getNumberOfPeriods($loanTermInYears, $repaymentPeriod)
   {
      switch ($repaymentPeriod) {
         case 'daily':
            return $loanTermInYears * 365;
         case 'weekly':
            return $loanTermInYears * 52;
         case 'monthly':
            return $loanTermInYears * 12;
         case 'quarterly':
            return $loanTermInYears * 4;
         case 'semi_annually':
            return $loanTermInYears * 2;
         case 'yearly':
            return $loanTermInYears;
         default:
            throw new \InvalidArgumentException('Invalid repayment period');
      }
   }

   /**
    * Calculates the number of installments to be made in a  year
    *
    * @param [type] $repaymentPeriod
    * @return int
    */
   private function getPaymentsPerYear($repaymentPeriod)
   {
      switch ($repaymentPeriod) {
         case 'monthly':
            return 12;
         case 'quarterly':
            return 4;
         case 'semi_annually':
            return 2;
         case 'yearly':
            return 1;
         case 'weekly':
            return 52; // Assuming a standard year
         case 'daily':
            return 365; // Assuming a standard year
         default:
            return 12; // Default to monthly
      }
   }

   /**
    * This function armotizes the loan basing on flat rate method
    *
    * @param [type] $loanAmount
    * @param [type] $totalInterest
    * @param [type] $loanTermInYears
    * @param [type] $repaymentPeriod
    * @param [type] $releaseDate
    * @return array
    */
   private function generateFlatRateAmortizationTable($loanAmount, $totalInterest, $loanTermInYears, $repaymentPeriod, $releaseDate)
   {
      // Convert release date to a Carbon instance
      $currentDate = Carbon::parse($releaseDate);

      // Calculate the number of periods based on repayment period
      switch ($repaymentPeriod) {
         case 'daily':
            $periods = $loanTermInYears * 365;
            $interval = 'day';
            break;
         case 'weekly':
            $periods = $loanTermInYears * 52;
            $interval = 'week';
            break;
         case 'monthly':
            $periods = $loanTermInYears * 12;
            $interval = 'month';
            break;
         case 'quarterly':
            $periods = $loanTermInYears * 4;
            $interval = 'quarter';
            break;
         case 'semi_annually':
            $periods = $loanTermInYears * 2;
            $interval = '6 months'; // Change this to the appropriate handling
            break;
         case 'yearly':
            $periods = $loanTermInYears;
            $interval = 'year';
            break;
         default:
            $periods = 1;
            $interval = 'month';
            break;
      }

      // Calculate equal principal repayment and interest per period
      $principalPerPeriod = $loanAmount / $periods;
      $interestPerPeriod = $totalInterest / $periods;

      // Initialize the outstanding principal balance
      $principalBalance = $loanAmount;

      // Generate amortization schedule
      $schedule = [];
      for ($i = 1; $i <= $periods; $i++) {
         // Update the due date correctly using Carbon
         $dueDate = $currentDate->copy();

         // Add the appropriate interval based on the selected repayment period
         if ($repaymentPeriod === 'semi_annually') {
            $dueDate->addMonths(6 * ($i - 1)); // Adding 6 months for semi-annual
         } else {
            $dueDate->add($i - 1, $interval);
         }

         $schedule[] = [
            'due_date' => $dueDate->toDateString(),
            'principal' => round($principalPerPeriod, 2),
            'interest' => round($interestPerPeriod, 2),
            'total_payment' => round($principalPerPeriod + $interestPerPeriod, 2),
            'principal_balance' => round($principalBalance - $principalPerPeriod, 2)
         ];

         // Update the remaining balance
         $principalBalance -= $principalPerPeriod;
      }

      return $schedule;
   }
   /**
    * This function armotizes the loan basing on reducing balance equal principal
    *
    * @param [type] $loanAmount
    * @param [type] $annualInterestRate
    * @param [type] $loanTermInYears
    * @param [type] $repaymentPeriod
    * @param [type] $releaseDate
    * @return array
    */
   private function generateReducingBalanceEqualPrincipal($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate)
   {
      // Get the number of payment periods based on loan term and repayment frequency
      $periods = $this->getNumberOfPeriods($loanTermInYears, $repaymentPeriod);
      // Get the number of periods in a year based on the repayment period
      $periodsInYear = $this->getPaymentsPerYear($repaymentPeriod);
      // Calculate the principal repayment amount per period
      $principalPerPeriod = $loanAmount / $periods;
      // Initialize the remaining balance
      $principalBalance = $loanAmount;
      $schedule = [];
      // Parse the release date for calculations
      $currentDate = Carbon::parse($releaseDate);

      for ($i = 1; $i <= $periods; $i++) {
         // Calculate interest for the current period based on the remaining principal balance
         $interestForPeriod = ($principalBalance * $annualInterestRate) / 100 / $periodsInYear;
         // Calculate the total payment for the current period
         $totalPayment = $principalPerPeriod + $interestForPeriod;

         // Append the current period's payment details to the schedule
         $schedule[] = [
            'due_date' => $currentDate->add($this->getDateInterval($repaymentPeriod))->toDateString(),
            'principal' => round($principalPerPeriod, 2),
            'interest' => round($interestForPeriod, 2),
            'total_payment' => round($totalPayment, 2),
            'principal_balance' => round($principalBalance - $principalPerPeriod, 2)
         ];

         // Update the principal balance after the payment
         $principalBalance -= $principalPerPeriod;
      }

      return $schedule;
   }
   /**
    * This function armotizes the loan basing on reducing balance equal installment
    *
    * @param [type] $loanAmount
    * @param [type] $annualInterestRate
    * @param [type] $loanTermInYears
    * @param [type] $repaymentPeriod
    * @param [type] $releaseDate
    * @return array
    */
   private function generateReducingBalanceEqualInstallment($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate)
   {
      // Get the number of periods based on loan term and repayment period
      $periods = $this->getNumberOfPeriods($loanTermInYears, $repaymentPeriod);
      // Adjust the interest rate based on the repayment frequency
      $interestRatePerPeriod = ($annualInterestRate / 100) / $this->getPaymentsPerYear($repaymentPeriod);

      // Calculate the installment amount using the correct formula for reducing balance
      $installment = $loanAmount * $interestRatePerPeriod / (1 - pow((1 + $interestRatePerPeriod), -$periods));

      $principalBalance = $loanAmount;
      $schedule = [];
      $currentDate = Carbon::parse($releaseDate);

      for ($i = 1; $i <= $periods; $i++) {
         $interestForPeriod = ($principalBalance * $interestRatePerPeriod);
         $principalForPeriod = $installment - $interestForPeriod;

         // Ensure the principal does not go negative
         if ($principalForPeriod > $principalBalance) {
            $principalForPeriod = $principalBalance;
         }

         $schedule[] = [
            'due_date' => $currentDate->add($this->getDateInterval($repaymentPeriod))->toDateString(),
            'principal' => round($principalForPeriod, 2),
            'interest' => round($interestForPeriod, 2),
            'total_payment' => round($installment, 2),
            'principal_balance' => round($principalBalance - $principalForPeriod, 2)
         ];

         $principalBalance -= $principalForPeriod;
      }

      return $schedule;
   }

   /**
    * This function armotizes the loan basing on Interest Only Method
    *
    * @param [type] $loanAmount
    * @param [type] $annualInterestRate
    * @param [type] $loanTermInYears
    * @param [type] $repaymentPeriod
    * @param [type] $releaseDate
    * @return array
    */
   private function generateInterestOnlySchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate)
   {
      $periods = $this->getNumberOfPeriods($loanTermInYears, $repaymentPeriod);
      $interestPerPeriod = ($loanAmount * $annualInterestRate / 100) / $this->getPaymentsPerYear($repaymentPeriod);
      $schedule = [];
      $currentDate = Carbon::parse($releaseDate);

      for ($i = 1; $i <= $periods; $i++) {
         $schedule[] = [
            'due_date' => $currentDate->add($this->getDateInterval($repaymentPeriod))->toDateString(),
            'principal' => $i === $periods ? round($loanAmount, 2) : 0, // Principal paid only at the end
            'interest' => round($interestPerPeriod, 2),
            'total_payment' => $i === $periods ? round($loanAmount + $interestPerPeriod, 2) : round($interestPerPeriod, 2),
            'principal_balance' => $i === $periods ? 0 : round($loanAmount, 2)
         ];
      }

      return $schedule;
   }
   /**
    * This function armotizes the loan basing on Compound Interest
    *
    * @param [type] $loanAmount
    * @param [type] $annualInterestRate
    * @param [type] $loanTermInYears
    * @param [type] $repaymentPeriod
    * @param [type] $releaseDate
    * @return array
    */
   private function generateCompoundInterestSchedule($loanAmount, $annualInterestRate, $loanTermInYears, $repaymentPeriod, $releaseDate)
   {
      $periods = $this->getNumberOfPeriods($loanTermInYears, $repaymentPeriod);
      $interestRatePerPeriod = ($annualInterestRate / 100) / $this->getPaymentsPerYear($repaymentPeriod);
      $schedule = [];
      $currentDate = Carbon::parse($releaseDate);
      $principalBalance = $loanAmount;

      for ($i = 1; $i <= $periods; $i++) {
         $interestForPeriod = $principalBalance * $interestRatePerPeriod;
         $principalForPeriod = $loanAmount / $periods;
         $totalPayment = $principalForPeriod + $interestForPeriod;

         $schedule[] = [
            'due_date' => $currentDate->add($this->getDateInterval($repaymentPeriod))->toDateString(),
            'principal' => round($principalForPeriod, 2),
            'interest' => round($interestForPeriod, 2),
            'total_payment' => round($totalPayment, 2),
            'principal_balance' => round($principalBalance + $interestForPeriod - $principalForPeriod, 2)
         ];

         $principalBalance += $interestForPeriod - $principalForPeriod;
      }

      return $schedule;
   }
   /**
    * This used to calculate how much time should pass between each repayment
    *
    * @param [type] $repaymentPeriod
    * @return void
    */
   private function getDateInterval($repaymentPeriod)
   {
      switch ($repaymentPeriod) {
         case 'daily':
            return CarbonInterval::days(1);
         case 'weekly':
            return CarbonInterval::weeks(1);
         case 'monthly':
            return CarbonInterval::months(1);
         case 'quarterly':
            return CarbonInterval::months(3);
         case 'semi_annually':
            return CarbonInterval::months(6);
         case 'yearly':
            return CarbonInterval::years(1);
         default:
            throw new \InvalidArgumentException("Invalid repayment period: $repaymentPeriod");
      }
   }
}
