<?php

namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Http\JsonResponse;
use App\Entities\AccountingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function expensecategories()
   {
      $business_id = request()->attributes->get('business_id');
      $page_title = 'Expense Categories';
      $categories = ExpenseCategory::where('is_subcat', 0)->where('business_id',$business_id)->get();
      $accounts_array =$this->getAllChartOfAccounts();
      return response()->json($categories);
      $accounts_lookup = [];

      foreach ($accounts_array as $account) {
          $accounts_lookup[$account['id']] = $account['name'] . '-' . $account['primaryType'];
      }
      
      foreach ($categories as &$category) {
          $expense_account_id = $category['expense_account'];
          
          if (isset($accounts_lookup[$expense_account_id])) {
              $category['expense_account'] = $accounts_lookup[$expense_account_id];
          }
      }

      return response()->json($categories);

      return view('webmaster.expensecategories.index', compact('page_title', 'categories','accounts_array'));
   }

   public function accounttypeCreate()
   {
      $page_title = 'Add Account Type';
      return view('webmaster.accounttypes.create', compact('page_title'));
   }

   public function expensecategoryStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'code'        => 'required',
        'description'   => 'required',
      ], [
         'name.required'               => 'The name is required',
         'code.required'               => 'The code is required',
         'description.required'        => 'The description is required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

         $category = new ExpenseCategory();
         $category->expense_account = $request->expenseAccount;
         $category->name             = $request->name;
         $category->code             = $request->code;
         $category->is_subcat        = $request->has('is_subcat') ? 1 : 0;
         if($request->has('is_subcat')) {
            $category->parent_id     = $request->parent_id;
         }
         $category->description      = $request->description;
         $category->business_id      = request()->attributes->get("business_id");
         $category->save();


      $notify[] = ['success', 'Expense Category added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
   }

   public function edit($id)
   {
     $business_id = request()->attributes->get('business_id');
     $expense = ExpenseCategory::find($id);
     $categories = ExpenseCategory::where('is_subcat', 0)->where('business_id',$business_id)->get();
     $accounts_array =$this->getAllChartOfAccounts();
     
     $view = view('webmaster.expensecategories.edit')->with(compact('expense','categories','accounts_array'))->render();
     return response()->json(['html'=>$view]);
   }
   public function update(Request $request)
   {

     $validator = Validator::make($request->all(), [
     'name' => 'required',
     'code' => 'required',
     'description' => 'required'
     ], [
     'name.required' => 'The name is required',
     'code.required' => 'The code is required',
     'description.required' => 'The description is required'
     ]);

     if($validator->fails()){
        return response()->json([
        'status' => 400,
        'message' => $validator->errors()
        ]);
     }

        $category = ExpenseCategory::find($request->id);
        $category->name = $request->name;
        $category->code = $request->code;
        $category->is_subcat = $request->has('is_subcat') ? 1 : 0;
        if($request->has('is_subcat')) {
        $category->parent_id = $request->parent_id;
     }
        $category->description = $request->description;
        $category->business_id = request()->attributes->get("business_id");
        $category->expense_account = $request->expenseAccount;
        $category->save();

        // Save the category
        if ($category->save()) {
            return response()->json(['status' => 200, 'message' => 'Category updated successfully!']);
        } else {
             return response()->json(['status' => 500, 'message' => 'Failed to update category.']);
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
              'name'=>$account->name,
              'primaryType'=>$account->account_primary_type,
              'subType'=>$translatedText ,
              'currency' =>$account->account_currency
          ];
      }

      return $accounts_array;
   }
}
