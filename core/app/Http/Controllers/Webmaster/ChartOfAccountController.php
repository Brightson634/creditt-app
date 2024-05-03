<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountType;
use App\Models\AccountTransaction;
use App\Models\Currency;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChartOfAccountController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function chartofaccounts()
   {
      $page_title = 'Chart Of Accounts';
      $chartofaccounts = ChartOfAccount::all();
      return view('webmaster.chartofaccounts.index', compact('page_title', 'chartofaccounts'));
   }

   public function chartofaccountCreate()
   {
      $page_title = 'Add Chart Of Account';
      $parentaccounts = ChartOfAccount::all();
      $accounttypes = ChartOfAccountType::where('is_subaccount', 0)->get();
      $currencies = Currency::all();
      $paymenttypes = PaymentType::all();
      return view('webmaster.chartofaccounts.create', compact('page_title','accounttypes', 'currencies', 'paymenttypes', 'parentaccounts'));
   }

   public function chartofaccountStore(Request $request)
   {
      $rules = [
        'name'                => 'required',
        'accountsubtype_id'   => 'required',
        'code'                => 'required',
        'currency_id'         => 'required',
        'description'         => 'required',
      ];

      $messages = [
         'name.required'               => 'The chart of account name is required.',
         'accountsubtype_id.required'  => 'The account type is required',
         'code.required'               => 'The general ledger code is required',
         'currency_id.required'        => 'The  currency is required',
         'description.required'        => 'The  description is required'
      ];

      if ($request->has('has_balance')) {
         $rules += [
            'opening_balance'    => 'required|numeric',
            'paymenttype_id'     => 'required',
         ];
            
         $messages += [
            'opening_balance.required'    => 'The opening balance is required',
            'opening_balance.numeric'    => 'The opening balance should be a number',
            'paymenttype_id.required'     => 'The  payment type is required'
         ];
      }

      if ($request->has('is_subaccount')) {
         $rules += [
            'parent_id'    => 'required',
         ];
            
         $messages += [
            'parent_id.required'     => 'The  parent account is required'
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $accounttype = ChartOfAccountType::where('id', $request->accountsubtype_id)->first();

      $account = new ChartOfAccount();
      $account->name                      = $request->name;
      $account->code                      = $request->code;
      $account->is_subaccount               = $request->has('is_subaccount') ? 1 : 0;
      if($request->has('is_subaccount')) {
         $account->parent_id        = $request->parent_id;
      }
      $account->currency_id               = $request->currency_id;
      $account->description               = $request->description;
      $account->accounttype_id            = $accounttype->parent_id;
      $account->accountsubtype_id         = $request->accountsubtype_id;
      $account->has_balance               = $request->has('has_balance') ? 1 : 0;
      if($request->has('has_balance')) {
         $account->opening_balance        = $request->opening_balance;
         $account->paymenttype_id         = $request->paymenttype_id;
      }
      $account->save();
      
      $notify[] = ['success', 'Chart of Account added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.chartofaccounts')
      ]);
   }

   public function chartofaccountAccountbook($id)
   {
      $account = ChartOfAccount::find($id);
      $page_title = 'AccountBook: ' . $account->code . ' - ' . $account->name;
      $transactions = AccountTransaction::where('account_id', $id)->get();
      return view('webmaster.chartofaccounts.accountbook', compact('account', 'page_title', 'transactions'));
   }
}
