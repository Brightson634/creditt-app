<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Expense;
use App\Utilities\Util;
use App\Utils\AccountingUtil;
use App\Utility\Currency;
use App\Models\PaymentType;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExpenseController extends Controller
{
  protected $util;
  protected $accountingUtil;
   public function __construct(Util $util, AccountingUtil $accountingUtil)
   {
     $this->middleware('auth:webmaster');
     $this->util = $util;
     $this->accountingUtil = $accountingUtil;
   }

   public function expenses()
   {
      $page_title = 'Expenses';
      $expenses = Expense::all();
      $accounts = ChartOfAccount::all();
      $payments = PaymentType::all();
      $accounts_array = $this->getAllChartOfAccounts();
      // return new JsonResponse($expenses);
      return view('webmaster.expenses.index', compact('page_title', 'expenses', 'accounts_array', 'payments'));
   }

   public function expenseCreate()
   {
      $branchId =request()->attributes->get('business_id');
      $page_title = 'Add Expense';
      $categories = ExpenseCategory::where('is_subcat', 0)->where('business_id',$branchId)->get();
      $accounts = ChartOfAccount::all();
      $payments = PaymentType::all();
      $currencies = Currency::forDropdown();
      $exchangeRates =ExchangeRate::where('branch_id',request()->attributes->get('business_id'))->get();
      $branchIfo = Branch::find(request()->attributes->get('business_id'));
      $default_currency = $branchIfo->default_currency;

      $business_id = request()->attributes->get('business_id');
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

      // return new JsonResponse($accounts);
      return view('webmaster.expenses.create', compact('page_title', 'categories', 'accounts', 'payments','currencies',
      'default_currency','exchangeRates','accounts_array'));
   }

   public function expenseStore(Request $request)
   {
    
      $validator = Validator::make($request->all(), [
        'account_id'        => 'required',
        'subcategory_id'   => 'required',
        'paymenttype_id'   => 'required',
        'name'   => 'required',
        'amount'   => 'required|numeric',
        'description'   => 'required',
        'amount_currency'=>'required'
      ], [
         'account_id.required'          => 'The account is required.',
         'subcategory_id.required'      => 'The expense category is required',
         'paymenttype_id.required'      => 'The payment type is required',
         'name.required'                => 'The expense title is required',
         'amount.required'              => 'The amount is required',
         'description.required'         => 'The description is required',
         'amount_currency.required'     => 'Payment Currency is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      try {
        DB::beginTransaction();
        $subcategory = ExpenseCategory::where('id', $request->subcategory_id)->first();

        $expense = new Expense();
        $expense->name              = $request->name;
        $expense->amount            = $request->amount;
        $expense->account_id        = $request->account_id;
        $expense->category_id       = $subcategory->parent_id;
        $expense->subcategory_id    = $request->subcategory_id;
        $expense->paymenttype_id    = $request->paymenttype_id;
        $expense->description       = $request->description;
        $expense->save();

        $user_id = ($request->attributes->get('user'))->id;
        $business_id = $request->attributes->get('business_id');
        $paymentAccount = $request->account_id;
        $expenseAccount = $subcategory->expense_account;
        $amount = $request->get('amount');
        $date = Carbon::createFromFormat('Y-m-d', $request->get('date'))->format('Y-m-d H:i:s');
        $accounting_settings = $this->accountingUtil->getAccountingSettings($business_id);
        $ref_no = $request->get('ref_no');
        $ref_count = $this->util->setAndGetReferenceCount('accounting_transfer');
        
        if (empty($ref_no)) {
            $prefix = ! empty($accounting_settings['pay_prefix']) ?
            $accounting_settings['pay_prefix'] : '';

            // Generate reference number
            $ref_no = $this->util->generateReferenceNumber('accounting_transfer', $ref_count, $business_id, $prefix);
        }

        $acc_trans_mapping = new AccountingAccTransMapping();
        $acc_trans_mapping->business_id = $business_id;
        $acc_trans_mapping->ref_no = $ref_no;
        $acc_trans_mapping->type = 'expense';
        $acc_trans_mapping->created_by = $user_id;
        $acc_trans_mapping->operation_date = $date;
        $acc_trans_mapping->save();

        $from_transaction_data = [
            'acc_trans_mapping_id' => $acc_trans_mapping->id,
            'amount' => $this->util->num_uf($amount),
            'type' => 'credit',
            'sub_type' => 'payment',
            'accounting_account_id' => $paymentAccount,
            'created_by' => $user_id,
            'operation_date' => $date,
        ];

        $to_transaction_data = $from_transaction_data;
        $to_transaction_data['accounting_account_id'] = $expenseAccount;
        $to_transaction_data['type'] = 'debit';

        AccountingAccountsTransaction::create($from_transaction_data);
        AccountingAccountsTransaction::create($to_transaction_data);

        DB::commit();

       $notify[] = ['success', 'Expense added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.expenses')
      ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::emergency('File:'.$e->getFile().' Line:'.$e->getLine().' Message:'.$e->getMessage());

        return response()->json([
            'success' => 0,
            'code' => 500,
            'msg' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }

      // insertAccountTransaction($request->account_id, 'DEBIT', $request->amount, $request->description);

      // $notify[] = ['success', 'Expense added Successfully!'];
      // session()->flash('notify', $notify);

      // return response()->json([
      //   'status' => 200,
      //   'url' => route('webmaster.expenses')
      // ]);
   }

    /**
    * Returns all charts of accounts for a given branch
    *
    * @return void
    */
    public function getAllChartOfAccounts()
    {
       $business_id = request()->attributes->get('business_id');
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
 
       return $accounts_array;
    }


}
