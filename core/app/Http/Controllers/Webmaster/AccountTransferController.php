<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\AccountTransfer;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountTransferController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function accounttransfers()
   {
      $page_title = 'Account Transfers';
      $accounttransfers = AccountTransfer::all();
      $accounts = ChartOfAccount::all();
      return view('webmaster.accounttransfers.index', compact('page_title', 'accounts', 'accounttransfers'));
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

   public function accounttransferStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'debit_account'        => 'required',
        'credit_account'   => 'required',
        'amount'        => 'required',
        'description'   => 'required'
      ], [
         'debit_account.required'     => 'The debit account is required.',
         'credit_account.required'    => 'The credit account is required',
         'amount.required'            => 'The transfer amount is required.',
         'description.required'       => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $transfer = new AccountTransfer();
      $transfer->debit_account      = $request->debit_account;
      $transfer->credit_account     = $request->credit_account;
      $transfer->amount             = $request->amount;
      $transfer->description        = $request->description;
      $transfer->date               = $request->date;
      $transfer->save();

      insertAccountTransaction($request->debit_account, 'DEBIT', $request->amount, $request->description);
      insertAccountTransaction($request->credit_account, 'CREDIT', $request->amount, $request->description);

      $notify[] = ['success', 'Account Transfer added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
   }
}
