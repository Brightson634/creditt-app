<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\AccountTransaction;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\AccountDeposit;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use App\Entities\AccountingAccountsTransaction;
use Illuminate\Support\Facades\Log;
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
    // return response()->json($accountdeposits);
    // $accounts = ChartOfAccount::all();
    $payments = PaymentType::all();
    return view('webmaster.accountdeposits.index', compact('page_title', 'accountdeposits', 'payments'));
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

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }


    DB::beginTransaction();

    try {

      $deposit = new AccountDeposit();
      $deposit->account_id       = memberAccountId($request->account_id);
      $deposit->paymenttype_id   = $request->paymenttype_id;
      $deposit->amount           = $request->amount;
      $deposit->depositor        = $request->depositor;
      $deposit->date             = $request->date;
      $deposit->description      = $request->description;
      $deposit->save();

      // Insert account transaction
      insertAccountTransaction(
        $request->account_id,
        'deposit',
        $request->amount,
        $request->description,
        $request->date,
        $deposit->id
      );

      DB::commit();

      // Notify success and return response
      $notify[] = ['success', 'Account Deposit added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
      ]);
    } catch (\Exception $e) {
      // Rollback the transaction if any error occurs
      DB::rollBack();

      // Log the error for debugging if necessary
      Log::error('Deposit Error: ' . $e->getMessage());

      return response()->json([
        'status' => 500,
        'message' => 'An error occurred while processing the transaction.' . $e->getMessage()
      ]);
    }
  }

  public function accountDepositShow($id)
  {
    $deposit = AccountDeposit::findorFail($id);
    $view = view('webmaster.accountdeposits.show', compact('deposit'))->render();
    return response()->json(['details' => $view]);
  }
  public function accountDepositEdit($id)
  {
    $deposit = AccountDeposit::findorFail($id);
    $memberAccount = MemberAccount::find($deposit->account_id);
    $chartOAId = $memberAccount->accounting_accounts->id;
    $deposit->account_id = $chartOAId;
    $payments = PaymentType::all();
    // return response()->json($deposit);
    $view = view('webmaster.accountdeposits.edit', compact('deposit', 'payments'))->render();
    return response()->json(['details' => $view]);
  }

  public function accountDepositUpdate(Request $request, $id)
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

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    DB::beginTransaction();

    try {
      // Retrieve the existing deposit
      $deposit = AccountDeposit::findOrFail($id);
      // Update the deposit details
      $deposit->account_id       = memberAccountId($request->account_id);
      $deposit->paymenttype_id   = $request->paymenttype_id;
      $deposit->amount           = $request->amount;
      $deposit->depositor        = $request->depositor;
      $deposit->date             = $request->date;
      $deposit->description      = $request->description;
      $deposit->save();

      // Update account transaction
      insertUpdateAccountTransaction(
        $request->account_id,
        'deposit',
        $request->amount,
        $request->description,
        $request->date,
        $id
      );

      DB::commit();
      $notify[] = ['success', 'Account Deposit updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Deposit Update Error: ' . $e->getMessage());

      return response()->json([
        'status' => 500,
        'message' => 'An error occurred while processing the transaction. ' . $e->getMessage()
      ]);
    }
  }

  public function accountDepositDestroy($id)
  {
    // Find the deposit by ID in all models
    $depositAcc = AccountDeposit::find($id);
    $depositTrans = AccountTransaction::where('deposit_id', $id)->first();
    $depositCAO = AccountingAccountsTransaction::where('deposit_id', $id)->first();

    if ($depositAcc) {
      // Delete the deposit in AccountDeposit
      $depositAcc->delete();

      // Check if there is a corresponding transaction in AccountTransaction
      if ($depositTrans) {
        $depositTrans->delete();
      }

      // Check if there is a corresponding transaction in AccountingAccountsTransaction
      if ($depositCAO) {
        $depositCAO->delete();
      }

      return response()->json([
        'success' => true,
        'message' => 'Deposit successfully deleted!',
      ]);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'Deposit not found!',
      ], 404);
    }
  }

  public function receipt($id)
  {
    $deposit = AccountDeposit::findorFail($id);
    $memberAccount = MemberAccount::find($deposit->account_id);
    $member =$memberAccount->member;
    $memberName=ucfirst(strtolower($member->fname)). ' '.ucfirst(strtolower($member->lname));

    return view('webmaster.receipts.deposit',compact('deposit','memberName','member'));
  }
}
