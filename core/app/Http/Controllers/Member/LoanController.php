<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Loan;
use App\Models\Saving;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
  public function __construct()
  { 
     $this->middleware('auth:member');
  }

  public function myloans()
  {
   $page_title = 'Loans';
   $loans = Loan::where('member_id', member()->id)->get();
   return view('member.loans.index', compact('page_title','loans'));
  }

   public function loanCreate()
   {
      $page_title = 'Request Loan';
      $types = LoanType::all();
      return view('member.loans.create', compact('page_title', 'types',));
   }

   public function loanStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'request_amount'   => 'required|numeric',
        'type_id'     => 'required',
        'reason'     => 'required'
      ], [
        'request_amount.required'     => 'The loan request amount is required.',
        'request_amount.numeric'     => 'The request amount should be a value',
        'type_id.required'       => 'The loan type is required',
        'reason.required'  => 'The loan request reason is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $loan = new Loan();
      $loan->loan_no = generateLoanNumber();
      $loan->member_id = member()->id;
      $loan->type_id = $request->type_id;
      $loan->request_amount = $request->request_amount;
      $loan->request_date = date('Y-m-d');
      $loan->reason = $request->reason;
      $loan->save();

      $memberNotification = new MemberNotification();
      $memberNotification->member_id = member()->id;
      $memberNotification->type = 'LOAN';
      $memberNotification->title = 'Loan Request';
      $memberNotification->detail = 'Your have requested a loan amount of ' .showAmount($request->request_amount);
      $memberNotification->url = NULL;
      $memberNotification->save();

      $notify[] = ['success', 'Loan Request submitted Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('member.loans')
      ]);

   }
  
}
