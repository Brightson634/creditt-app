<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Withdraw;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\AccountDeposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Account Deposits';
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
          $request->date
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
}
