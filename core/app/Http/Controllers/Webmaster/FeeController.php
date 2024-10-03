<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Entities\AccountingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class FeeController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function fees()
   {
      $page_title = 'Fees';
      $fees = Fee::all();
      $accounts_array = $this->getAllChartOfAccounts();
      return view('webmaster.fees.index', compact('page_title', 'fees','accounts_array'));
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


   public function feeCreate()
   {
      $page_title = 'Add Fee';
      $accounts_array = $this->getAllChartOfAccounts();
      return view('webmaster.fees.create', compact('page_title','accounts_array'));
   }

   public function feeStore(Request $request)
   {
      $rules = [
        'account_id'      => 'required',
        'name'            => 'required',
        'type'            => 'required',
        'rate_type'       => 'required',
        'period'          => 'required',
      ];
      
      $messages = [
         'account_id.required' => 'The account is required.',
         'name.required'       => 'The fee name are required.',
         'type.required'       => 'The fee type are required',
         'rate_type.required'  => 'The fee rate type is required',
         'period.required'     => 'The fee period type is required'
      ];

      if ($request->rate_type == 'fixed') {
         $rules += [
            'amount'        => 'required|numeric',
         ];
            
         $messages += [
            'amount.required'    => 'The amount is required',
            'amount.numeric'     => 'The amount should be a number value',
         ];
      }
      if ($request->rate_type == 'percent') {
         $rules += [
            'rate'        => 'required|numeric',
         ];
            
         $messages += [
            'rate.required'    => 'The rate is required',
            'rate.numeric'     => 'The rate should be a number value',
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $fee = new Fee();
      $fee->name = $request->name;
      $fee->type = $request->type;
      $fee->rate_type = $request->rate_type;
      $fee->period = $request->period;
      $fee->amount = ($request->rate_type == 'fixed') ? $request->amount : 0;
      if ($request->rate_type == 'percent') {
         $fee->rate = $request->rate;
         $fee->rate_value = $request->rate / 100;
      }
      $fee->account_id = $request->account_id;

      $fee->save();

      // insertAccountTransaction($request->account_id, 'CREDIT', $request->amount, $request->description);


      $notify[] = ['success', 'Fee added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.fees')
      ]);
   }

   public function feeEdit($id)
   {
      $page_title = 'Edit  Fee';
      $accounts_array = $this->getAllChartOfAccounts();
      $fee = Fee::findOrFail($id);
      return view('webmaster.fees.edit', compact('page_title','accounts_array','fee'));
   }

   public function feeUpdate(Request $request)
   {
      $rules = [
         'account_id'      => 'required',
         'name'            => 'required',
         'type'            => 'required',
         'rate_type'       => 'required',
         'period'          => 'required',
       ];
       
       $messages = [
          'account_id.required' => 'The account is required.',
          'name.required'       => 'The fee name are required.',
          'type.required'       => 'The fee type are required',
          'rate_type.required'  => 'The fee rate type is required',
          'period.required'     => 'The fee period type is required'
       ];
 
       if ($request->rate_type == 'fixed') {
          $rules += [
             'amount'        => 'required|numeric',
          ];
             
          $messages += [
             'amount.required'    => 'The amount is required',
             'amount.numeric'     => 'The amount should be a number value',
          ];
       }
       if ($request->rate_type == 'percent') {
          $rules += [
             'rate'        => 'required|numeric',
          ];
             
          $messages += [
             'rate.required'    => 'The rate is required',
             'rate.numeric'     => 'The rate should be a number value',
          ];
       }
 
       $validator = Validator::make($request->all(), $rules, $messages);
       if ($validator->fails()) {
          return response()->json([
             'status' => 400,
             'message' => $validator->errors()
          ]);
       }
 
       $fee = Fee::findOrFail($request->id);
       $fee->name = $request->name;
       $fee->type = $request->type;
       $fee->rate_type = $request->rate_type;
       $fee->period = $request->period;
       $fee->amount = ($request->rate_type == 'fixed') ? $request->amount : 0;
       if ($request->rate_type == 'percent') {
          $fee->rate = $request->rate;
          $fee->rate_value = $request->rate / 100;
       }
       $fee->account_id = $request->account_id;
 
       $fee->save();
 
       // insertAccountTransaction($request->account_id, 'CREDIT', $request->amount, $request->description);
 
 
       $notify[] = ['success', 'Fee Updated Successfully!'];
       session()->flash('notify', $notify);
 
       return response()->json([
         'status' => 200,
         'url' => route('webmaster.fees')
       ]);

   }

   public function feeDestroy($id)
   {
    $fee = Fee::findOrFail($id);
    $fee->delete();
    $notify[] = ['success', 'Fee  deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Fee  deleted successfully.');
   }



}
