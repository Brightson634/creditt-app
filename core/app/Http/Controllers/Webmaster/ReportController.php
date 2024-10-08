<?php

namespace App\Http\Controllers\Webmaster;

use DB;
use App\Utils\AccountingUtil;
// use App\Utilities\ModuleUtil;
use Illuminate\Http\Response;
use App\Utilities\BusinessUtil;
use App\Utility\BusinessLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Entities\AccountingAccount;
use App\Services\PermissionsService;

class ReportController extends Controller
{
    protected $accountingUtil;

    protected $businessUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(AccountingUtil $accountingUtil, BusinessUtil $businessUtil)
    {
        $this->accountingUtil = $accountingUtil;
        $this->businessUtil = $businessUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        PermissionsService::check('view_accounting_reports');
        // $business_id = request()->session()->get('user.business_id');
       $business_id = request()->attributes->get('business_id');
       $page_title="Reports";
      

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }
        PermissionsService::check('view_accounting_reports');

        $first_account = AccountingAccount::where('business_id', $business_id)
                            ->where('status', 'active')
                            ->first();
        $ledger_url = null;
        if (! empty($first_account)) {
            $ledger_url = route('webmaster.accounting.ledger', $first_account);
        }
        // dd($ledger_url);
        return view('webmaster.report.index')
            ->with(compact('ledger_url','page_title'));
    }

    /**
     * Trial Balance
     *
     * @return Response
     */
    public function trialBalance()
    {
        // $business_id = request()->session()->get('user.business_id');
       $business_id = request()->attributes->get('business_id');
       $page_title ="Trial Balance";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (! empty(request()->start_date) && ! empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
            $start_date = $fy['start'];
            $end_date = $fy['end'];
        }

        $accounts = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                            ->where('business_id', $business_id)
                            ->whereDate('AAT.operation_date', '>=', $start_date)
                            ->whereDate('AAT.operation_date', '<=', $end_date)
                            ->select(
                                DB::raw("SUM(IF(AAT.type = 'credit', AAT.amount, 0)) as credit_balance"),
                                DB::raw("SUM(IF(AAT.type = 'debit', AAT.amount, 0)) as debit_balance"),
                                'accounting_accounts.name'
                            )
                            ->groupBy('accounting_accounts.name')
                            ->get();
        // return new JsonResponse($accounts);

        return view('webmaster.report.trial_balance')
            ->with(compact('accounts', 'start_date', 'end_date','page_title'));
    }

    /**
     * Trial Balance
     *
     * @return Response
     */
    public function balanceSheet()
    {
        $business_id = request()->attributes->get('business_id');
        $page_title ="Balance Sheet";
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (! empty(request()->start_date) && ! empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
            $start_date = $fy['start'];
            $end_date = $fy['end'];
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $assets = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['asset'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        $liabilities = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['liability'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        $equities = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['equity'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        return view('webmaster.report.balance_sheet')
            ->with(compact('assets', 'liabilities', 'equities', 'start_date', 'end_date','page_title'));
    }

    public function accountReceivableAgeingReport()
    {
        // $business_id = request()->session()->get('user.business_id');
       $business_id = request()->attributes->get('business_id');
        $page_title ="Account Receivable Ageing Report";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'sell', 'contact', $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('webmaster.report.account_receivable_ageing_report')
        ->with(compact('report_details', 'business_locations','page_title'));
    }

    public function accountPayableAgeingReport()
    {
        $business_id = request()->session()->get('user.business_id');
       $business_id = request()->attributes->get('business_id');
        $page_title ="Account Payable Ageing Report";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $location_id = request()->input('location_id', null);
        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'purchase', 'contact',
        $location_id);
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('webmaster.report.account_payable_ageing_report')
        ->with(compact('report_details', 'business_locations','page_title'));
    }

    public function accountReceivableAgeingDetails()
    {
        // $business_id = request()->session()->get('user.business_id');
       $business_id = request()->attributes->get('business_id');
        $page_title ="Account Receivable Ageing Details";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'sell', 'due_date',
        $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('webmaster.report.account_receivable_ageing_details')
        ->with(compact('business_locations', 'report_details','page_title'));
    }

    public function accountPayableAgeingDetails()
    {
        // $business_id = request()->session()->get('user.business_id');
        $business_id=2;
        $page_title ="Account Payable Ageing Details";
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_reports'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'purchase', 'due_date',
        $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('webmaster.report.account_payable_ageing_details')
        ->with(compact('business_locations', 'report_details','page_title'));
    }
}
