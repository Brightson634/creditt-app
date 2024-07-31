<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Branch;
use App\Models\ExchangeRate;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ChartOfAccount;
use App\Utility\Currency;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExpenseController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function expenses()
   {
      $page_title = 'Expenses';
      $expenses = Expense::all();
      $accounts = ChartOfAccount::all();
      $payments = PaymentType::all();
      return view('webmaster.expenses.index', compact('page_title', 'expenses', 'accounts', 'payments'));
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
      return view('webmaster.expenses.create', compact('page_title', 'categories', 'accounts', 'payments','currencies','default_currency','exchangeRates'));
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

      insertAccountTransaction($request->account_id, 'DEBIT', $request->amount, $request->description);

      $notify[] = ['success', 'Expense added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.expenses')
      ]);
   }


}
