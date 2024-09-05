<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Branch;
use App\Utilities\Util;
use App\Utility\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Utilities\ModuleUtil;
use App\Utils\AccountingUtil;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Yajra\DataTables\Facades\DataTables;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;

class TransferController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $util;
    protected $accountingUtil;

    /**
     * Constructor
     *
     * @param  ProductUtils  $product
     * @return void
     */
    public function __construct(Util $util, AccountingUtil $accountingUtil)
    {
        $this->middleware(['auth:webmaster']);
        $this->util = $util;
        $this->accountingUtil = $accountingUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $business_id = $request->attributes->get('business_id');
        $page_title ="Transfer";

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {

            $transfers = AccountingAccTransMapping::where('accounting_acc_trans_mappings.business_id', $business_id)
                        ->join('staff_members as u', 'accounting_acc_trans_mappings.created_by', 'u.id')
                        ->join('accounting_accounts_transactions as from_transaction', function ($join) {
                            $join->on('from_transaction.acc_trans_mapping_id', '=', 'accounting_acc_trans_mappings.id')
                                    ->where('from_transaction.type', 'debit');
                        })
                        ->join('accounting_accounts_transactions as to_transaction', function ($join) {
                            $join->on('to_transaction.acc_trans_mapping_id', '=', 'accounting_acc_trans_mappings.id')
                                    ->where('to_transaction.type', 'credit');
                        })
                        ->join('accounting_accounts as from_account',
                        'from_transaction.accounting_account_id', 'from_account.id')
                        ->join('accounting_accounts as to_account',
                        'to_transaction.accounting_account_id', 'to_account.id')
                        ->where('accounting_acc_trans_mappings.type', 'transfer')
                        ->select(['accounting_acc_trans_mappings.id',
                            'accounting_acc_trans_mappings.ref_no',
                            'accounting_acc_trans_mappings.operation_date',
                            'accounting_acc_trans_mappings.note',
                            DB::raw("CONCAT(COALESCE(u.title, ''),' ',COALESCE(u.fname, ''),' ',COALESCE(u.lname,''))
                            as added_by"),
                            'from_transaction.amount',
                            'from_account.name as from_account_name',
                            'to_account.name as to_account_name',
                        ]);

            if (! empty(request()->start_date) && ! empty(request()->end_date)) {
                $start = request()->start_date;
                $end = request()->end_date;
                $transfers->whereDate('accounting_acc_trans_mappings.operation_date', '>=', $start)
                            ->whereDate('accounting_acc_trans_mappings.operation_date', '<=', $end);
            }

            if (! empty(request()->transfer_from)) {
                $transfers->where('from_account.id', request()->transfer_from);
            }

            if (! empty(request()->transfer_to)) {
                $transfers->where('to_account.id', request()->transfer_to);
            }

            return Datatables::of($transfers)
                ->addColumn(
                    'action', function ($row) {
                        $html = '<div class="btn-group">
                                <button type="button" class=" btn btn-info active tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-info tw-w-max"
                                    data-toggle="dropdown" aria-expanded="false">'.'Actions'.
                                    '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="width:50px;">';
                        // if (auth()->user()->can('accounting.edit_transfer')) {
                            $html .= '<li>
                                <a href="#" style="background-color:transparent;border:none;" data-href="'.action([\App\Http\Controllers\Webmaster\TransferController::class, 'edit'],
                                [$row->id]).'" class="btn btn-dark btn-modal transferUpdate"  title="update Transfer">
                                    <i class="fas fa-edit"></i>'.'
                                </a>
                            </li>';
                        // }
                        // if (auth()->user()->can('accounting.delete_transfer')) {
                            $html .= '<li>
                                    <a href="#" style="background-color:transparent; border:none" data-href="'.action([\App\Http\Controllers\Webmaster\TransferController::class, 'destroy'], [$row->id]).'" class="btn btn-danger delete_transfer_button" title="delete">
                                        <i class="fas fa-trash" aria-hidden="true"></i>'.'
                                    </a>
                                    </li>';
                        // }

                        $html .= '</ul></div>';

                        return $html;
                    })
                // ->editColumn('amount', function ($row) {
                //     return $this->util->num_f($row->amount, true);
                // })
                ->editColumn('operation_date', function ($row) {
                    return $this->util->format_date($row->operation_date, true);
                })
                ->filterColumn('added_by', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(u.title, ''), ' ',
                    COALESCE(u.fname, ''), ' ', COALESCE(u.lname, '')) like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('webmaster.transfer.index',compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $business_id = $request->attributes->get('business_id');
        $currencies = Currency::forDropdown();
        $exchangeRates =ExchangeRate::where('branch_id',request()->attributes->get('business_id'))->get();
        $branchIfo = Branch::find(request()->attributes->get('business_id'));
        $default_currency = $branchIfo->default_currency;
        $accounts = AccountingAccount::forDropdown($business_id, true);
        // return new JsonResponse($accounts);
        // return $accounts;
        $translations = [
            "accounting::lang.accounts_payable" => "Accounts Payable",
            "accounting::lang.accounts_receivable" => "Accounts Receivable (AR)",
            "accounting::lang.credit_card" => "Credit Card",
            "accounting::lang.current_assets" => "Current Assets",
            "accounting::lang.cash_and_cash_equivalents" => "Cash and Cash Equivalents",
            "accounting::lang.fixed_assets" => "Fixed Assets",
            "accounting::lang.non_current_assets" => "Non Current Assets",
            "accounting::lang.cost_of_sale" => "Cost of Sale",
            "accounting::lang.expenses" => "Expenses",
            "accounting::lang.other_expense" => "Other Expense",
            "accounting::lang.income" => "Income",
            "accounting::lang.other_income" => "Other Income",
            "accounting::lang.owners_equity" => "Owner Equity",
            "accounting::lang.current_liabilities" => "Current Liabilities",
            "accounting::lang.non_current_liabilities" => "Non-Current Liabilities",
        ];

        $accounts_array = [];
        foreach ($accounts as $account) {
            $translatedText = $translations[$account->sub_type] ?? $account->sub_type;
            $accounts_array[] = [
                'id' => $account->id,
                'name'=>$account->name,
                'primaryType'=>$account->account_primary_type,
                'subType'=>$translatedText ,
                'currency' =>$account->account_currency
            ];
        }

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.add_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $view =view('webmaster.transfer.create',compact('currencies','accounts_array','exchangeRates','default_currency'))->render();
            return response()->json(['html'=>$view]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $business_id = $request->attributes->get('business_id');
    
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.add_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }
    
        try {
            DB::beginTransaction();
    
            $user_id = ($request->attributes->get('user'))->id;
    
            $from_account = $request->get('from_account');
            $to_account = $request->get('to_account');
            $amount = $request->get('amount');
            $date = Carbon::createFromFormat('m/d/Y H:i', $request->get('operation_date'))->format('Y-m-d H:i:s');
            $accounting_settings = $this->accountingUtil->getAccountingSettings($business_id);
            $ref_no = $request->get('ref_no');
            $ref_count = $this->util->setAndGetReferenceCount('accounting_transfer');
            
            if (empty($ref_no)) {
                $prefix = ! empty($accounting_settings['transfer_prefix']) ?
                $accounting_settings['transfer_prefix'] : '';
    
                // Generate reference number
                $ref_no = $this->util->generateReferenceNumber('accounting_transfer', $ref_count, $business_id, $prefix);
            }
    
            $acc_trans_mapping = new AccountingAccTransMapping();
            $acc_trans_mapping->business_id = $business_id;
            $acc_trans_mapping->ref_no = $ref_no;
            $acc_trans_mapping->note = $request->get('note');
            $acc_trans_mapping->type = 'transfer';
            $acc_trans_mapping->created_by = $user_id;
            $acc_trans_mapping->operation_date = $date;
            $acc_trans_mapping->save();
    
            $from_transaction_data = [
                'acc_trans_mapping_id' => $acc_trans_mapping->id,
                'amount' => -($this->util->num_uf($amount)),
                'type' => 'debit',
                'sub_type' => 'transfer',
                'accounting_account_id' => $from_account,
                'created_by' => $user_id,
                'operation_date' => $date,
            ];
    
            $to_transaction_data = $from_transaction_data;
            $to_transaction_data['accounting_account_id'] = $to_account;
            $to_transaction_data['amount']=$this->util->num_uf($amount);
            $to_transaction_data['type'] = 'credit';
    
            AccountingAccountsTransaction::create($from_transaction_data);
            AccountingAccountsTransaction::create($to_transaction_data);
    
            DB::commit();
    
            return response()->json([
                'success' => 1,
                'code' => 200,
                'msg' => 'Transfer successfully added.',
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().' Line:'.$e->getLine().' Message:'.$e->getMessage());
    
            return response()->json([
                'success' => 0,
                'code' => 500,
                'msg' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
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
    public function edit(Request $request,$id)
    {
        // $business_id = request()->session()->get('user.business_id');
          $business_id = $request->attributes->get('business_id');
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.edit_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $mapping_transaction = AccountingAccTransMapping::where('id', $id)
                            ->where('business_id', $business_id)->firstOrFail();

            $debit_tansaction = AccountingAccountsTransaction::where('acc_trans_mapping_id', $id)
                                    ->where('type', 'debit')
                                    ->first();
            $credit_tansaction = AccountingAccountsTransaction::where('acc_trans_mapping_id', $id)
                                    ->where('type', 'credit')
                                    ->first();
            $from_account =(AccountingAccount::where('id',$debit_tansaction->accounting_account_id)->first())->name;
            $to_account =(AccountingAccount::where('id',$credit_tansaction->accounting_account_id)->first())->name;
            $view =view('webmaster.transfer.edit')->with(compact('mapping_transaction',
            'debit_tansaction', 'credit_tansaction','from_account','to_account'))->render();
            // return view('webmaster.transfer.edit')->with(compact('mapping_transaction',
            // 'debit_tansaction', 'credit_tansaction'));
            return response()->json(['html'=>$view]);
        }
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
        $business_id = $request->attributes->get('business_id');

        try {
            $mapping_transaction = AccountingAccTransMapping::where('id', $id)
                            ->where('business_id', $business_id)
                            ->firstOrFail();

            $debit_tansaction = AccountingAccountsTransaction::where('acc_trans_mapping_id', $id)
                                    ->where('type', 'debit')
                                    ->first();
            $credit_tansaction = AccountingAccountsTransaction::where('acc_trans_mapping_id', $id)
                                    ->where('type', 'credit')
                                    ->first();

            DB::beginTransaction();
           
            $from_account = $request->get('from_account');
            $to_account = $request->get('to_account');
         
            $amount = $request->get('amount');
            $date = Carbon::createFromFormat('Y-m-d H:i', $request->get('operation_date'))->format('Y-m-d H:i:s');
            $ref_no = $request->get('ref_no');
            $ref_count = $this->util->setAndGetReferenceCount('accounting_transfer');
            if (empty($ref_no)) {
                // Generate reference number
                $ref_no = $this->util->generateReferenceNumber('accounting_transfer', $ref_count);
            }

            // Update mapping transaction
            $mapping_transaction->ref_no = $ref_no;
            $mapping_transaction->note = $request->get('note');
            $mapping_transaction->operation_date = $date;
            $mapping_transaction->save();

            // Update debit transaction
            $debit_tansaction->accounting_account_id = $from_account;
            $debit_tansaction->operation_date = $date;
            $debit_tansaction->amount = $this->util->num_uf($amount);
            // $debit_tansaction->amount =$amount;
            $debit_tansaction->save();

            // Update credit transaction
            $credit_tansaction->accounting_account_id = $to_account;
            $credit_tansaction->operation_date = $date;
            $credit_tansaction->amount =$this->util->num_uf($amount);
            // $credit_tansaction->amount =$amount;
            $credit_tansaction->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Transfer updated successfully!',
                'code' => 200 
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong. Please try again.'.$e->getMessage(),
                'code' => 500 // Internal server error code
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
        // $business_id = request()->session()->get('user.business_id');
        $business_id = $request->attributes->get('business_id');
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.delete_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $user_id = request()->session()->get('user.id');

        $acc_trans_mapping = AccountingAccTransMapping::where('id', $id)
                        ->where('business_id', $business_id)->firstOrFail();

        if (! empty($acc_trans_mapping)) {
            $acc_trans_mapping->delete();
            AccountingAccountsTransaction::where('acc_trans_mapping_id', $id)->delete();
        }

        return ['success' => 1,
            'msg' =>'Success',
        ];
    }
}
