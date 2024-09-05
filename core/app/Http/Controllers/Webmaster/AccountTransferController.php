<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Utilities\Util;
use Illuminate\Http\Request;
use App\Utils\AccountingUtil;
use App\Models\ChartOfAccount;
use App\Models\AccountTransfer;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;

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
    // $accounts = ChartOfAccount::all();
    return view('webmaster.accounttransfers.index', compact('page_title', 'accounttransfers'));
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
      'debit_account'   => 'required',
      'credit_account'  => 'required',
      'amount'          => 'required|numeric',
      'description'     => 'required'
    ], [
      'debit_account.required'  => 'The debit account is required.',
      'credit_account.required' => 'The credit account is required.',
      'amount.required'         => 'The transfer amount is required.',
      'description.required'    => 'The description is required.'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    //check whether transfer amount is greater than account balance
    $business_id = request()->attributes->get('business_id');
    $accountBalance = getAccountBalance($request->debit_account,$business_id);
    
    if($request->amount > $accountBalance){
      return response()->json([
          'status' => 400,
          'overdraft' =>'Transfer amount exceeds available account balance'
        ]);
    }  

    DB::beginTransaction(); 

    try {
  
      $transfer = new AccountTransfer();
      $transfer->debit_account = memberAccountId($request->debit_account);
      $transfer->credit_account = memberAccountId($request->credit_account);
      $transfer->amount = $request->amount;
      $transfer->description = $request->description;
      $transfer->date = $request->date;
      $transfer->save();

      // Create transactions for both debit and credit accounts
      $this->createAccountTransaction($request->debit_account, 'transferfrom', $request->amount, $request->description, $request->date);
      $this->createAccountTransaction($request->credit_account, 'transferto', $request->amount, $request->description, $request->date);

      // Insert data into the main Chart of Accounts (COA)
      $this->insertInMainCOA($request->debit_account, $request->credit_account, $request->date, $request->amount, $request->description);

      DB::commit();

      $notify[] = ['success', 'Account Transfer added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
    } catch (\Exception $e) {
      DB::rollBack(); // Rollback the transaction on failure

      \Log::error('Account Transfer Failed: ' . $e->getMessage());

      return response()->json([
        'status' => 500,
        'message' => 'Something went wrong while processing the transfer: ' . $e->getMessage()
      ], 500);
    }
  }

  public function createAccountTransaction($account_id, $type, $amount, $description, $transDate,)
  {
    $business_id = request()->attributes->get('business_id');

    // $account = AccountingAccount::where('id', $account_id)->first();
    // Fetch previous balance once
    $previousBalance = getAccountBalance($account_id, $business_id);

    // Create the account transaction
    $transaction = new AccountTransaction();
    $transaction->account_id = memberAccountId($account_id);
    $transaction->type = $type === 'transferto' ? 'credit' : 'debit';
    $transaction->previous_amount = $previousBalance;
    $transaction->amount = $amount;

    // Update current balance based on transaction type
    $transaction->current_amount = $type === 'transferto' ? $previousBalance + $amount : $previousBalance - $amount;
    $transaction->description = $description;
    $transaction->date = $transDate;
    $transaction->save();
  }
  /**
   * Stores transfer transactions in main chart of accounts
   *
   * @return mixed
   */
  public function insertInMainCOA($fromAcc, $toAcc, $transferDate, $transferAmount, $note)
  {
    $business_id = request()->attributes->get('business_id');
    $accountingUtil = new AccountingUtil();
    $util = new Util();
    try {
      DB::beginTransaction();

      $user_id = (request()->attributes->get('user'))->id;

      $from_account = $fromAcc;
      $to_account = $toAcc;
      $amount = $transferAmount;
      $date = $transferDate;
      $accounting_settings = $accountingUtil->getAccountingSettings($business_id);
      $ref_no = request()->get('ref_no');
      $ref_count = $util->setAndGetReferenceCount('accounting_transfer');

      if (empty($ref_no)) {
        $prefix = ! empty($accounting_settings['transfer_prefix']) ?
          $accounting_settings['transfer_prefix'] : '';

        // Generate reference number
        $ref_no = $util->generateReferenceNumber('accounting_transfer', $ref_count, $business_id, $prefix);
      }

      $acc_trans_mapping = new AccountingAccTransMapping();
      $acc_trans_mapping->business_id = $business_id;
      $acc_trans_mapping->ref_no = $ref_no;
      $acc_trans_mapping->note = $note;
      $acc_trans_mapping->type = 'transfer';
      $acc_trans_mapping->created_by = $user_id;
      $acc_trans_mapping->operation_date = $date;
      $acc_trans_mapping->save();

      $from_transaction_data = [
        'acc_trans_mapping_id' => $acc_trans_mapping->id,
        'amount' => - ($util->num_uf($amount)),
        'type' => 'debit',
        'sub_type' => 'transfer',
        'accounting_account_id' => $from_account,
        'created_by' => $user_id,
        'operation_date' => $date,
      ];

      $to_transaction_data = $from_transaction_data;
      $to_transaction_data['accounting_account_id'] = $to_account;
      $to_transaction_data['amount'] = $util->num_uf($amount);
      $to_transaction_data['type'] = 'credit';

      AccountingAccountsTransaction::create($from_transaction_data);
      AccountingAccountsTransaction::create($to_transaction_data);

      DB::commit();
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
}
