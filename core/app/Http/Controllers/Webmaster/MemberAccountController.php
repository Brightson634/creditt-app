<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\MemberAccount;
use App\Models\StaffMember;
use App\Models\Statement;
use App\Models\Member;
use App\Models\AccountType;
use App\Models\Fee;
use App\Models\FeeRange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberAccountController extends Controller
{
   public function __construct()
   { 
     $this->middleware('auth:webmaster');
   }
 
   public function memberaccounts()
   {
      $page_title = 'Member Accounts';
      $accounts = MemberAccount::all();
      return view('webmaster.memberaccounts.index', compact('page_title', 'accounts'));
   }

   public function memberaccountCreate()
   {
      $page_title = 'Create Member Account';
      $account_no = generateAccountNumber();
      $staffs = StaffMember::all();
      $members = Member::all();
      $accounttypes = AccountType::all();
      $fees = Fee::all();
      return view('webmaster.memberaccounts.create', compact('page_title', 'account_no', 'staffs', 'members', 'accounttypes', 'fees'));
   }


   public function memberaccountStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'member_id'                 => 'required',
        'accounttype_id'            => 'required',
        'fees_id'                   => 'required',
        'opening_balance'           => 'required|numeric',
        'account_purpose'           => 'required'
      ], [
         'member_id.required'                   => 'The name is required.',
         'accounttype_id.required'              => 'The  minimum amount is required',
         'fees_id.required'                     => 'The fee is required',
         'opening_balance.required'             => 'The interest rate is required',
         'account_purpose.required'             => 'The account purpose is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $accounttype = AccountType::where('id', $request->accounttype_id)->first();
      //$feesTotal = Fee::whereIn('id', $request->fees_id)->sum('amount');
      $fees = Fee::whereIn('id', $request->fees_id)->get();
      $feesTotal = 0;
      foreach ($fees as $fee) {
         if ($fee->rate_type === 'fixed') {
            $feesTotal += $fee->amount;
         } elseif ($fee->rate_type === 'percent') {
            $feesTotal += ($fee->rate_value) * $request->opening_balance;
         } elseif ($fee->rate_type === 'range') {
            $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
            foreach ($feeRanges as $range) {
               if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                  $feesTotal += $range->amount;
                  break;
               }
            }
          }
      }

      $account = new  MemberAccount();
      $account->member_id           = $request->member_id;
      $account->accounttype_id      = $request->accounttype_id;
      $account->fees_id             = implode(',', $request->fees_id);
      $account->account_no          = $request->account_no;
      //$account->opening_balance     = $request->opening_balance;
      $account->opening_balance     = $request->opening_balance - $feesTotal;
      $account->current_balance     = $request->opening_balance;
      $account->available_balance   = $request->opening_balance;
      $account->account_purpose     = $request->account_purpose;
      $account->account_status    = ($request->opening_balance >= $accounttype->min_amount)? 1:0;
      $account->staff_id         = webmaster()->id;
      $account->save();

      foreach ($request->fees_id as $feeId) {
         $fee = Fee::find($feeId);
         $statement = new Statement();
         $statement->member_id = $request->member_id;
         $statement->account_id = $account->id;
         $statement->type = 'CHARGES';
         $statement->detail = 'Charge - : ' . $fee->name;
         //$statement->amount = $fee->amount;
         if ($fee->rate_type === 'fixed') {
            $statement->amount = $fee->amount;
         } elseif ($fee->rate_type === 'percent') {
            $statement->amount = $fee->rate_value * $request->opening_balance;
         } elseif ($fee->rate_type === 'range') {
            $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
            foreach ($feeRanges as $range) {
               if ($request->opening_balance >= $range->min_amount && $request->opening_balance <= $range->max_amount) {
                  $statement->amount = $range->amount;
                  break;
               }
            }
         }
         $statement->status = 0;
         $statement->save();
      }

      $notify[] = ['success', 'Account added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.memberaccounts')
      ]);
   }


}