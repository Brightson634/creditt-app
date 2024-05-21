<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\LoanPayment;
use App\Models\LoanPlan;
use App\Models\Setting;
use App\Models\Member;
use App\Models\SavingYear;
use App\Models\StaffMember;
use App\Models\ChartOfAccount;
use App\Models\Loan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanPaymentController extends Controller
{
   public function __construct()
   { 
     $this->middleware('auth:webmaster');
   }

   public function loanpayments()
   {
      $page_title = 'Loan Payments';
      $repayments = LoanPayment::orderBy('id','DESC')->get();
      // $loans = Loan::all();
      return view('webmaster.loanpayments.index', compact('page_title', 'repayments'));
   }

   public function loanpaymentCreate()
   {
      $page_title = 'Add Loan Payments';
      $staffs = StaffMember::all();
      $accounts = ChartOfAccount::all();
      $loans = Loan::where('repayment_amount', '!=', 0 )->orderBy('id','DESC')->get();
      // dd($loans);
      return view('webmaster.loanpayments.create', compact('page_title', 'loans', 'staffs', 'accounts'));
   }

   public function loanMember($id = null)
   {
      $data = Loan::find($id);
      if ($data) {
           return response()->json([
            'loan_id'  => $data->id,
            'formatloanamount'  => showAmount($data->balance_amount),
            'loan_amount'  => $data->balance_amount,
         ]);
      }
      return response()->json([
            'loan_id'  => '',
            'formatloanamount' => '',
            'loan_amount' => '',
      ]);
   }

   public function loanpaymentStore(Request $request)
   {
      $rules = [
         'loan_id'   => 'required',
         'account_id'   => 'required',
         'paid_by'   => 'required',
         'staff_id'  => 'required',
         'note'      => 'required',
      ];

      $messages = [
         'loan_id.required'     => 'please select the loan',
         'account_id.required'     => 'please select the account',
         'paid_by.required'     => 'The paid by person is required.',
         'staff_id.required'    => 'The recieved by staff is required',
         'note.required'        => 'The payment note is required'
      ];

      if ($request->payment_type == 'partial') {
         $rules['partial_payment'] = 'required|numeric';
         $messages['partial_payment.required'] = 'Please enter partial amount';
         $messages['partial_payment.numeric'] = 'The amount should be a number value';
      }

      if ($request->payment_type == 'full') {
         $rules['full_payment'] = 'required|numeric';
         $messages['full_payment.required'] = 'Please enter amount';
         $messages['full_payment.numeric'] = 'The amount should be a number value';
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
          return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $setting = Setting::first();
      $loan = Loan::where('id', $request->loan_id)->first();

      $repayment = new LoanPayment();
      $repayment->loan_id = $request->loan_id;
      $repayment->member_id = $loan->member_id;
      if($request->payment_type == 'partial') {
         $repayment->loan_amount = $loan->repayment_amount;
         $repayment->repaid_amount = $amount = $request->partial_payment;
         $repayment->balance_amount = $loan->repayment_amount - $request->partial_payment;
         $loan->repaid_amount += $request->partial_payment;
         $loan->repayment_amount -= $request->partial_payment;
         $loan->pstatus = 1;
      } 
      if ($request->payment_type == 'full') {
         $repayment->loan_amount = $loan->repayment_amount;
         $repayment->repaid_amount = $amount = $request->full_payment;
         $repayment->balance_amount = $loan->repayment_amount - $request->full_payment;
         $loan->repaid_amount += $request->full_payment;
         $loan->repayment_amount -= $request->full_payment;
         $loan->pstatus = 2;
      }
      $repayment->payment_type = $request->payment_type;
      $repayment->paid_by = $request->paid_by;
      $repayment->staff_id = $request->staff_id;
      $repayment->note = $request->note;
      $repayment->date = date('Y-m-d');
      $repayment->save();
      $loan->save();

      insertAccountTransaction($request->account_id, 'CREDIT', $amount, $request->description);

      $notify[] = ['success', 'Loan Payments added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.loanpayments')
      ]);
}




}