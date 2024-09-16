<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Member;
use App\Models\Withdraw;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\AccountDeposit;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccountsTransaction;

class WithdrawController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Account Withdraws';
        $withdraws = Withdraw::all();
        $payments = PaymentType::all();
        return view('webmaster.accountwithdraws.index',compact('page_title','payments','withdraws'));
    }

    public function accountwithdrawStore(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'account_id'          => 'required',
        'paymenttype_id'      => 'required',
        'amount'              => 'required|numeric',
        'withdrawer'           => 'required',
        'description'         => 'required'
      ], [
        'account_id.required'        => 'The account is required.',
        'paymenttype_id.required'    => 'The payment type is required',
        'amount.required'            => 'The amount is required.',
        'withdrawer.required'         => 'The withdrawer is required.',
        'description.required'       => 'The description is required'
      ]);
  
      if ($validator->fails()) {
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      //check whether withdraw amount is greater than account balance
      $business_id = request()->attributes->get('business_id');
      $accountBalance = getAccountBalance($request->account_id,$business_id);
      
      if($request->amount > $accountBalance){
        return response()->json([
            'status' => 400,
            'overdraft' =>'Withdraw amount exceeds available account balance'
          ]);
      }   
  
      
      DB::beginTransaction();
  
      try {
    
        $withdraw = new Withdraw();
        $withdraw->account_id       = memberAccountId($request->account_id);
        $withdraw->paymenttype_id   = $request->paymenttype_id;
        $withdraw->amount           = $request->amount;
        $withdraw->withdrawer       = $request->withdrawer;
        $withdraw->date             = $request->date;
        $withdraw->description      = $request->description;
        $withdraw->save();
  
        // Insert account transaction
        insertAccountTransaction(
          $request->account_id,
          'withdraw',
          $request->amount,
          $request->description,
          $request->date,
          $withdraw->id
        );
  
        DB::commit();
  
        // Notify success and return response
        $notify[] = ['success', 'Operation Successful!'];
        session()->flash('notify', $notify);
  
        return response()->json([
          'status' => 200,
        ]);
      } catch (\Exception $e) {
        DB::rollBack();
  
        Log::error('Deposit Error: ' . $e->getMessage());
  
        return response()->json([
          'status' => 500,
          'message' => 'An error occurred while processing the transaction.'.$e->getMessage()
        ]);
      }
    }

    public function accountWithdrawShow($id)
    {
      $withdraw = Withdraw::findorFail($id);
      $member = Member::findorFail($withdraw->memberAccount->member_id);
      $withdraw->account_holder=$member->lname.' '.$member->fname;
      $view = view('webmaster.accountwithdraws.show', compact('withdraw'))->render();
      return response()->json(['details' => $view]);
    }
    public function accountWithdrawEdit($id)
    {
      $withdraw = Withdraw::findorFail($id);
      $memberAccount = MemberAccount::find($withdraw->account_id);
      $chartOAId = $memberAccount->accounting_accounts->id;
      $withdraw->account_id = $chartOAId;
      $payments = PaymentType::all();
      // return response()->json($deposit);
      $view = view('webmaster.accountwithdraws.edit', compact('withdraw', 'payments'))->render();
      return response()->json(['details' => $view]);
    }
  
    public function accountWithdrawUpdate(Request $request, $id)
    {
  
      $validator = Validator::make($request->all(), [
        'account_id'          => 'required',
        'paymenttype_id'      => 'required',
        'amount'              => 'required|numeric',
        'withdrawer'           => 'required',
        'description'         => 'required'
      ], [
        'account_id.required'        => 'The account is required.',
        'paymenttype_id.required'    => 'The payment type is required',
        'amount.required'            => 'The amount is required.',
        'withdrawer.required'         => 'The depositor is required.',
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
        
        $withdraw = Withdraw::findOrFail($id);
  
        // Update the deposit details
        $withdraw->account_id       = memberAccountId($request->account_id);
        $withdraw->paymenttype_id   = $request->paymenttype_id;
        $withdraw->amount           = $request->amount;
        $withdraw->withdrawer        = $request->withdrawer;
        $withdraw->date             = $request->date;
        $withdraw->description      = $request->description;
        $withdraw->save();
  
        // Update account transaction
        insertUpdateAccountTransaction(
          $request->account_id,
          'withdraw',
          $request->amount,
          $request->description,
          $request->date,
          $id
        );
  
        DB::commit();
        $notify[] = ['success', 'Account Withdraw updated Successfully!'];
        session()->flash('notify', $notify);
  
        return response()->json([
          'status' => 200,
        ]);
      } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Withdraw Update Error: ' . $e->getMessage());
  
        return response()->json([
          'status' => 500,
          'message' => 'An error occurred while processing the transaction. ' . $e->getMessage()
        ]);
      }
    }
  
    public function accountWithdrawDestroy($id)
    {
      // Find the deposit by ID in all models
      $withdrawAcc = Withdraw::find($id);
      $withdrawTrans = AccountTransaction::where('withdraw_id', $id)->first();
      $withdrawCAO = AccountingAccountsTransaction::where('withdraw_id', $id)->first();
  
      if ($withdrawAcc) {
       
        $withdrawAcc->delete();
        if ($withdrawTrans) {
          $withdrawTrans->delete();
        }
        
        if ($withdrawCAO) {
          $withdrawCAO->delete();
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
      $withdraw = Withdraw::findorFail($id);
      $memberAccount = MemberAccount::find($withdraw->account_id);
      $member = $memberAccount->member;
      $memberName=ucfirst(strtolower($member->fname)). ' '.ucfirst(strtolower($member->lname));
      $chartOAId = $memberAccount->accounting_accounts->id;
      // $withdraw->account_id = $chartOAId;
      $payments = PaymentType::all();
      // return response()->json($withdraw->memberAccount);

      return view('webmaster.receipts.withdraw',compact('withdraw','memberName','member'));
    }
}
