<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\AccountDeposit;
use App\Models\ChartOfAccount;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountDepositController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function accountdeposits()
   {
      $page_title = 'Account Deposits';
      $accountdeposits = AccountDeposit::all();
      $accounts = ChartOfAccount::all();
      $payments = PaymentType::all();
      return view('webmaster.accountdeposits.index', compact('page_title', 'accounts', 'accountdeposits', 'payments'));
   }

   public function creditAccounts($id)
   {
      $accounts = ChartOfAccount::where('id', '!=', $id)->get();
      if ($accounts->isEmpty()) {
        return response()->json('<option value="">No account found</option>');
      }

      $optionsHtml = '<option value="">select credit account</option>';
      foreach ($accounts as $account) {
         $optionsHtml .= '<option value="' . $account->id . '">' . $account->code . ' - ' . $account->name . '</option>';
      }
      return response()->json($optionsHtml);
   }

   public function accountdepositStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'account_id'          => 'required',
        'paymenttype_id'      => 'required',
        'amount'              => 'required|numeric',
        'depositor'           => 'required',
        'description'         => 'required'
      ], [
         'account_id.required'        => 'The account is required.',
         'paymenttype_id.required'    => 'The payment type is required',
         'amount.required'            => 'The amount is required.',
         'depositor.required'         => 'The depositor is required.',
         'description.required'       => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $deposit = new AccountDeposit();
      $deposit->account_id       = $request->account_id;
      $deposit->paymenttype_id   = $request->paymenttype_id;
      $deposit->amount           = $request->amount;
      $deposit->depositor        = $request->depositor;
      $deposit->date             = $request->date;
      $deposit->description      = $request->description;
      $deposit->save();

      insertAccountTransaction($request->account_id, 'CREDIT', $request->amount, $request->description);

      $notify[] = ['success', 'Account Deposit added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
   }
}