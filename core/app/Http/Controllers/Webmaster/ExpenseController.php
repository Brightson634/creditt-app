<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Expense;
use App\Utilities\Util;
use App\Utility\Currency;
use App\Models\PaymentType;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Utils\AccountingUtil;
use App\Models\ChartOfAccount;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
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
    PermissionsService::check('view_expenses');
    $page_title = 'Expenses';
    $expenses = Expense::with('staff')->get();
    $accounts = ChartOfAccount::all();
    $payments = PaymentType::all();
    $accounts_array = $this->getAllChartOfAccounts();
    // return new JsonResponse($expenses);
    return view('webmaster.expenses.index', compact('page_title', 'expenses', 'accounts_array', 'payments'));
  }

  public function expenseCreate()
  {
    PermissionsService::check('add_expenses');
    $branchId = request()->attributes->get('business_id');
    $page_title = 'Add Expense';
    $categories = ExpenseCategory::where('is_subcat', 0)->where('tenant_id', $branchId)->get();
    $accounts = ChartOfAccount::all();
    $payments = PaymentType::all();
    $currencies = Currency::forDropdown();
    $exchangeRates = ExchangeRate::where('branch_id', request()->attributes->get('business_id'))->get();
    $branchIfo = Branch::first();
    $default_currency = $branchIfo->default_currency ?? null;
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
        'name' => $account->name,
        'primaryType' => $account->account_primary_type,
        'subType' => $translatedText,
        'currency' => $account->account_currency
      ];
    }

    // return new JsonResponse($accounts);
    return view('webmaster.expenses.create', compact(
      'page_title',
      'categories',
      'accounts',
      'payments',
      'currencies',
      'default_currency',
      'exchangeRates',
      'accounts_array'
    ));
  }

  public function expenseStore(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'account_id'        => 'required',
          'subcategory_id'    => 'required',
          'paymenttype_id'    => 'required',
          'name'              => 'required',
          'amount'            => 'required|numeric',
          'description'       => 'nullable|string',
          'amount_currency'   => 'required',
          'date'              => 'required',
      ], [
          'account_id.required'         => 'The account is required.',
          'subcategory_id.required'     => 'The expense category is required',
          'paymenttype_id.required'     => 'The payment type is required',
          'name.required'               => 'The expense title is required',
          'amount.required'             => 'The amount is required',
          'amount_currency.required'    => 'Payment Currency is required',
          'date.required'               => 'Date is required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 400,
              'message' => $validator->errors()
          ]);
      }

      try {
          DB::beginTransaction();

          $selectedCategory = ExpenseCategory::find($request->subcategory_id);

          $expense = new Expense();

          if ($selectedCategory && $selectedCategory->parent_id) {
              $expense->category_id    = $selectedCategory->parent_id;
              $expense->subcategory_id = $selectedCategory->id;
          } else {
              $expense->category_id    = $selectedCategory->id;
              $expense->subcategory_id = null;
          }

          $expense->name            = $request->name;
          $expense->amount          = $request->amount;
          $expense->account_id      = $request->account_id;
          $expense->paymenttype_id  = $request->paymenttype_id;
          $expense->description     = $request->description;
          $expense->date            = $request->date;
          $expense->staff_id        = webmaster()->id;
          $expense->save();

          // 🔹 Refactored Accounting Transaction Logic
          $this->recordAccountingTransactions($expense, $selectedCategory, $request);

          DB::commit();

          $notify[] = ['success', 'Expense added Successfully!'];
          session()->flash('notify', $notify);

          return response()->json([
              'status' => 200,
              'url' => route('webmaster.expenses')
          ]);
      } catch (\Exception $e) {
          DB::rollBack();
          \Log::emergency('File:' . $e->getFile() . ' Line:' . $e->getLine() . ' Message:' . $e->getMessage());

          return response()->json([
              'success' => 0,
              'code' => 500,
              'msg' => 'Something went wrong: ' . $e->getMessage(),
          ], 500);
      }
  }
  
  private function recordAccountingTransactions($expense, $selectedCategory, $request)
  {
      $expenseAccount = $selectedCategory->expense_account;
      $paymentAccount = $request->account_id;
      $amount = $this->util->num_uf($request->get('amount'));
      $date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
      $user_id = ($request->attributes->get('user'))->id;

      if ($expenseAccount && $paymentAccount) {

          // Payment (Credit)
          $payment_data = [
              'accounting_account_id' => $paymentAccount,
              'transaction_id' => null,
              'expense_id' => $expense->id,
              'transaction_payment_id' => null,
              'amount' => $amount,
              'type' => 'credit',
              'sub_type' => 'expense',
              'note' => "Payment made in reference to {$expense->name} expense",
              'map_type' => 'payment_account',
              'created_by' => $user_id,
              'operation_date' => $date,
          ];

          // Deposit (Debit)
          $deposit_data = [
              'accounting_account_id' => $expenseAccount,
              'transaction_id' => null,
              'expense_id' => $expense->id,
              'transaction_payment_id' => null,
              'amount' => $amount,
              'type' => 'debit',
              'sub_type' => 'expense',
              'note' => "Expense accumulated from {$expense->name}",
              'map_type' => 'deposit_to',
              'created_by' => $user_id,
              'operation_date' => $date,
          ];

          AccountingAccountsTransaction::create($payment_data);
          AccountingAccountsTransaction::create($deposit_data);
      }
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
        'name' => $account->name,
        'primaryType' => $account->account_primary_type,
        'subType' => $translatedText,
        'currency' => $account->account_currency
      ];
    }

    return $accounts_array;
  }

  public function expenseEdit($id)
  {
    PermissionsService::check('edit_expenses','Unauthorized action!');
    $expense = Expense::findOrFail($id);
    $tenant_id = request()->attributes->get('business_id');
    $page_title = 'Edit Expense';
    $categories = ExpenseCategory::where('is_subcat', 0)->where('tenant_id', $tenant_id)->get();
    $accounts = ChartOfAccount::all();
    $payments = PaymentType::all();
    $currencies = Currency::forDropdown();
    $exchangeRates = ExchangeRate::where('branch_id', request()->attributes->get('business_id'))->get();
    $branchIfo = Branch::where('tenant_id',(request()->attributes->get('business_id')))->first();
    $default_currency = $branchIfo->default_currency ?? null;

    // $business_id = request()->attributes->get('business_id');
    $accounts = AccountingAccount::forDropdown($tenant_id, true);
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
        'name' => $account->name,
        'primaryType' => $account->account_primary_type,
        'subType' => $translatedText,
        'currency' => $account->account_currency
      ];
    }

    // return new JsonResponse($accounts);
    return view('webmaster.expenses.edit', compact(
      'page_title',
      'categories',
      'accounts',
      'payments',
      'currencies',
      'default_currency',
      'exchangeRates',
      'accounts_array',
      'expense'
    ));

  }

  public function expenseUpdate(Request $request)
  {

  }

  public function expenseDestroy($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_expenses')) {
      $notify[] = ['error', 'Unauthorized action'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
  }
    $expense = Expense::findOrFail($id);
    $expense->delete();
    $notify[] = ['success', 'Expense deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back();
  }
  public function expenseReport(Request $request)
  {
      // PermissionsService::check('view_expense_reports');

      $page_title = 'Expenses Report';
      $business_id = $request->attributes->get('business_id');
      $categories = ExpenseCategory::where('is_subcat', 0)
          ->where('tenant_id', $business_id)
          ->get();

      if ($request->ajax()) {
          $query = Expense::with('category', 'subcategory', 'paymentType')
              ->select('expenses.*');

          if (!empty($request->start_date) && !empty($request->end_date)) {
              $query->whereBetween('expenses.created_at', [$request->start_date, $request->end_date]);
          }

          if (!empty($request->category)) {
              $query->where('category_id', $request->category);
          }

          $datatable = DataTables::of($query)
              ->addIndexColumn()
              ->addColumn('created_at', function ($row) {
                  return Carbon::parse($row->created_at)->format('F j, Y, g:i a');
              })
              ->addColumn('amount', function ($row) {
                  return generateComaSeparatedValue($row->amount);
              })
              ->addColumn('payment_type_name', function ($row) {
                  return $row->paymentType ? $row->paymentType->name : 'N/A';
              })
              ->addColumn('description', function ($row) {
                  return ucwords(strtolower($row->description));
              })
              ->addColumn('name', function ($row) {
                  return ucwords(strtolower($row->name));
              })
              ->addColumn('category_name', function ($row) {
                  return $row->category ? $row->category->name : 'N/A';
              })
              ->addColumn('subcategory_name', function ($row) {
                  return $row->subcategory ? $row->subcategory->name : 'N/A';
              });

            //Conditionally add Action Column with Mapping Logic
              if ($request->has('action') && $request->action) {
                  $datatable->addColumn('action', function ($row) {
                      $html = '
                      <div class="dropdown">
                          <button class="btn btn-sm btn-primary dropdown-toggle" 
                                type="button" 
                                id="actionMenu' . $row->id . '" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false">
                                <i class="fas fa-cogs mr-1"></i> ' . __('Actions') . '
                          </button>

                          <div class="dropdown-menu" aria-labelledby="actionMenu' . $row->id . '">';

                      //Conditional Map/Edit Mapping link
                      if (auth()->user()->can('edit_accounting_transactions')) {
                          $is_mapped = AccountingAccountsTransaction::where('expense_id', $row->id)
                              ->whereDate('operation_date', $row->date)
                              ->exists();

                          $mapUrl = action([\App\Http\Controllers\Webmaster\TransactionController::class, 'map']) .
                              '?id=' . $row->id . '&type=expense';

                          if (!$is_mapped) {
                              $html .= '
                                  <a href="#" 
                                    data-href="' . $mapUrl . '" 
                                    class="dropdown-item map_transaction" 
                                    data-date="' . $row->date . '" 
                                    data-acc="' . ($row->account_id ?? '') . '">
                                    <i class="fas fa-link mr-2 text-primary"></i> ' . __('Map Transaction') . '
                                  </a>';
                          } else {
                              $html .= '
                                  <a href="#" 
                                    data-href="' . $mapUrl . '" 
                                    class="dropdown-item map_transaction text-warning" 
                                    data-date="' . $row->date . '" 
                                    data-acc="' . ($row->account_id ?? '') . '">
                                    <i class="fas fa-edit mr-2"></i> ' . __('Edit Mapping') . '
                                  </a>';
                          }
                      }

                      // You can append other actions here (like edit/delete)
                      // Example:
                      // $html .= '<a href="'.route('webmaster.expenses.edit', $row->id).'" class="dropdown-item"><i class="fas fa-pen mr-2"></i> Edit Expense</a>';

                      $html .= '</div></div>';

                      return $html;
                  })
                  ->rawColumns(['action']);
              }

          return $datatable->make(true);
      }

      return view('webmaster.report.expense_report', compact('page_title', 'categories'));
  }

}