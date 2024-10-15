<?php

namespace App\Http\Controllers\Webmaster;

use App\Utility\Business;
use Illuminate\Http\Request;
use App\Utilities\ModuleUtil;
use App\Utils\AccountingUtil;
use Illuminate\Http\Response;
use App\Utility\ExpenseCategory;
use App\Utility\BusinessLocation;
use App\Entities\AccountingBudget;
use Illuminate\Routing\Controller;
use App\Entities\AccountingAccount;
use App\Services\PermissionsService;
use App\Entities\AccountingAccountType;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;

class SettingsAccController extends Controller
{
    protected $accountingUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(AccountingUtil $accountingUtil)
    {
        $this->accountingUtil = $accountingUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $business_id = request()->session()->get('user.business_id');
       $business_id = $request->attributes->get('business_id');
       $page_title ="Settings";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }
        $response=PermissionsService::check('view_accounting_settings');
        if ($response) {
            return $response;
        }

       $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
                                    ->where(function ($q) use ($business_id) {
                                        $q->whereNull('business_id')
                                        ->orWhere('business_id', $business_id);
                                    })
                                    ->get();

        $account_types = AccountingAccountType::accounting_primary_type();

        $accounting_settings = $this->accountingUtil->getAccountingSettings($business_id);

        $business_locations = BusinessLocation::where('business_id', $business_id)->get();

         $expence_categories = ExpenseCategory::where('business_id', $business_id)->get();
         
        return view('webmaster.settings.index')->with(compact('account_sub_types', 'account_types', 'accounting_settings', 'business_locations', 'expence_categories','page_title'));
    }

    public function resetData(Request $request)
    {
        // $business_id = request()->session()->get('user.business_id');
        $business_id = $request->attributes->get('business_id');


        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        //check for admin
        // if (! $this->accountingUtil->is_admin(auth()->user())) {
        //     abort(403, 'Unauthorized action.');
        // }

        //reset logic
        AccountingBudget::join('accounting_accounts', 'accounting_budgets.accounting_account_id', '=', 'accounting_accounts.id')
            ->where('accounting_accounts.business_id', $business_id)
            ->delete();

        AccountingAccountType::where('business_id', $business_id)
            ->delete();

        AccountingAccTransMapping::where('business_id', $business_id)->delete();

        AccountingAccountsTransaction::join('accounting_accounts', 'accounting_accounts_transactions.accounting_account_id', '=', 'accounting_accounts.id')
            ->where('business_id', $business_id)->delete();

        AccountingAccount::where('business_id', $business_id)->delete();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function saveSettings(Request $request)
    {
        // $business_id = request()->session()->get('user.business_id');
         $business_id = $request->attributes->get('business_id');


        // if (! (auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id,
        // 'accounting_module')))) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $accounting_settings = $request->only(['journal_entry_prefix', 'transfer_prefix', 'accounting_default_map']);

            Business::where('id', $business_id)
                        ->update(['accounting_settings' => json_encode($accounting_settings)]);

            //Update accounting_default_map for each locations
            $accounting_default_map = $request->get('accounting_default_map');
            foreach($accounting_default_map as $location_id => $details){
                BusinessLocation::where('id', $location_id)
                    ->update(['accounting_default_map' => json_encode($details)]);
            }

            $output = ['success' => true,
                'msg' => __('lang_v1.updated_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
