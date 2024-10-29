<?php

namespace App\Http\Controllers\Webmaster;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Setting;
use App\Models\LoanPlan;
use App\Models\SavingYear;
use App\Models\LoanPayment;
use App\Models\StaffMember;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Utils\AccountingUtil;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use App\Models\LoanRepaymentSchedule;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;

class LoanPaymentController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:webmaster');
   }

   public function loanpayments()
   {
      $response = PermissionsService::check('view_loan_repayments');
      if ($response) {
         return $response;
      }
      $page_title = 'Loan Payments';
      $repayments = LoanPayment::orderBy('id', 'DESC')->get();
      // $loans = Loan::all();
      return view('webmaster.loanpayments.index', compact('page_title', 'repayments'));
   }

   public function loanpaymentCreate()
   {
      PermissionsService::check('add_loan_repayment');
      $page_title = 'Add Loan Payments';
      $staffs = StaffMember::all();
      $accounts_array = CoaService::getAllChartOfAccounts();
      $loans = Loan::where('repayment_amount', '!=', 0)->orderBy('id', 'DESC')->get();
      // dd($loans);
      return view('webmaster.loanpayments.create', compact('page_title', 'loans', 'staffs', 'accounts_array'));
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
      if ($request->payment_type == 'partial') {
         $repayment->loan_amount = $loan->repayment_amount;
         $repayment->repaid_amount = $request->partial_payment;
         $repayment->balance_amount = $loan->repayment_amount - $request->partial_payment;
         $loan->repaid_amount += $request->partial_payment;
         $loan->repayment_amount -= $request->partial_payment;
         $loan->loan_due_date = $this->getNextPaymentDate($loan);
         $loan->balance_amount = $repayment->balance_amount;
         $loan->payment_status = 'in_progress';
         $loan->pstatus = 1;
      }
      if ($request->payment_type == 'full') {
         $repayment->loan_amount = $loan->repayment_amount;
         $repayment->repaid_amount = $request->full_payment;
         $repayment->balance_amount = $loan->repayment_amount - $request->full_payment;
         $loan->repaid_amount += $request->full_payment;
         $loan->repayment_amount -= $request->full_payment;
         $loan->payment_status = 'paid';
         $loan->pstatus = 2;
      }
      $repayment->payment_type = $request->payment_type;
      $repayment->paid_by = $request->paid_by;
      $repayment->staff_id = $request->staff_id;
      $repayment->note = $request->note;
      $repayment->date = date('Y-m-d');
      $repayment->save();
      $loan->last_payment_date = Carbon::today();
      $loan->save();


      // insertAccountTransaction($request->account_id, 'CREDIT', $amount, $request->description);

      $notify[] = ['success', 'Loan Payments added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200,
         'loanData' => $loan,
         'url' => route('webmaster.loanpayments')
      ]);
   }

   public function loanPaymentInfo(Request $request)
   {
      $entityInfo = Setting::find(1);
      $loanInfo = Loan::where('loan_no', $request->loan_no)->first();
      $loanPaymentDetails = LoanPayment::where('loan_id', $loanInfo->id)->first();
      $loanPaymentDetails->loan_number = $request->loan_no;
      $memberDetails = $loanPaymentDetails->member;
      // return response()->json(["members"=>$memberDetails,'entyity'=>$entityInfo]);
      $view = view(
         'webmaster.loanpayments.loanpayment_receipt',
         compact('entityInfo', 'loanInfo', 'loanPaymentDetails', 'memberDetails')
      )->render();
      return response()->json(['html' => $view]);
   }

   public function loanPaymentReceiptDownload(Request $request, $loan_no)
   {
      $page_title = 'Loan Payment';
      $entityInfo = Setting::find(1);
      $loanInfo = Loan::where('loan_no', $loan_no)->first();
      $loanPaymentDetails = LoanPayment::where('loan_id', $loanInfo->id)->first();
      $loanPaymentDetails->loan_number = $loan_no;
      $memberDetails = $loanPaymentDetails->member;
      $mpdf = new Mpdf();


      $html = view(
         'webmaster.loanpayments.loanpayment_receipt',
         compact('entityInfo', 'loanInfo', 'loanPaymentDetails', 'memberDetails')
      );
      $mpdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg}');
      $mpdf->WriteHTML($html);
      $pdfContent = $mpdf->Output('', 'S');
      return response($pdfContent)
         ->header('Content-Type', 'application/pdf')
         ->header('Content-Disposition', 'inline; filename="loan_receipt_#' . $loan_no . '.pdf"');
   }
   /**
    * This function returns the next loan payment date
    * @param Loan $loan
    * @return void
    */
   public function getNextPaymentDate(Loan $loan)
   {
      // Get the current due date
      $currentDueDate = Carbon::parse($loan->loan_due_date);

      // Determine the repayment frequency
      $recoveryMode = $loan->loanproduct->duration;
      switch ($recoveryMode) {
         case 'day':
            $timeBeforeNextInstallment = 1;
            $recoveryType = 'days';
            break;
         case 'week':
            $timeBeforeNextInstallment = 1;
            $recoveryType = 'weeks';
            break;
         case 'month':
            $timeBeforeNextInstallment = 1;
            $recoveryType = 'months';
            break;
         case 'quarter':
            $timeBeforeNextInstallment = 3;
            $recoveryType = 'months';
            break;
         case 'semi_year':
            $timeBeforeNextInstallment = 6;
            $recoveryType = 'months';
            break;
         case 'year':
            $timeBeforeNextInstallment = 1;
            $recoveryType = 'years';
            break;
         default:
            throw new \Exception('Invalid repayment mode');
      }

      // Calculate the next due date
      $nextDueDate = $currentDueDate->add($timeBeforeNextInstallment, $recoveryType);

      // Update the loan's due date in the database
      $loan_due_date = $nextDueDate->format('Y-m-d');
      return $loan_due_date;
   }

   public function loanPaymentSave(Request $request)
   {
      // Validate the request inputs
      $validatedData = $request->validate([
         'proof_of_payment' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
         'amount' => 'required|numeric',
         'date_due' => 'required|date',
         'payment_type' => 'required|string',
         'payment_mode' => 'required|string',
      ]);

      // Handle file upload if exists
      if ($request->hasFile('proof_of_payment')) {
         $file = $request->file('proof_of_payment');
         $fileName = member()->fname . '_payment_proof_' . uniqid() . '.' . $file->getClientOriginalExtension();
         $filePath = 'assets/uploads/loans/' . $fileName;
         $file->move(public_path('assets/uploads/loans'), $fileName);
      } else {
         $filePath = null;
      }

      $dueDate = Carbon::parse($validatedData['date_due'])->format('Y-m-d');
      $schedule = LoanRepaymentSchedule::where('member_id', $request->memberId)
         ->whereDate('due_date', $dueDate)
         ->first();

      if (!$schedule) {
         return redirect()->back()->withErrors(['error' => 'Repayment schedule not found for the given due date.']);
      }
      // Update repayment schedule details
      $schedule->amount_paid = $validatedData['amount'];
      $schedule->payment_status = $validatedData['payment_type'];
      $schedule->payment_mode = $validatedData['payment_mode'];
      $schedule->balance_amount = $schedule->amount_due - $validatedData['amount'];
      $schedule->proof_of_payment = $filePath;
      $schedule->save();
      return redirect()->back()->with('success', 'Payment proof uploaded successfully');
   }
   public function loanPaymentConfirm(Request $request)
   {
      $dueDate = Carbon::parse($request->date_due_confirm)->format('Y-m-d');
      $schedule = LoanRepaymentSchedule::where('member_id', $request->memberId)
         ->whereDate('due_date', $dueDate)
         ->first();

      return response()->json($schedule);

      if (!$schedule) {
         return redirect()->back()->withErrors(['error' => 'Repayment schedule not found for the given due date.']);
      }
      $schedule->is_verified = true;
      $schedule->verified_by = webmaster()->id;
      // $schedule->save;
      return response()->json($request);
   }
   public function loanRepayment($saccoAccount, $memberAccount, $loanAmount)
   {
      $business_id = request()->attributes->get('business_id');

      try {
         DB::beginTransaction();

         $user_id = webmaster()->id;

         $from_account = $saccoAccount;
         $to_account = $memberAccount;
         $amount = $loanAmount;
         $date = Carbon::now()->format('Y-m-d H:i:s');
         $accounting_settings = $this->accountingUtil->getAccountingSettings($business_id);
         $ref_no = '';
         $ref_count = $this->util->setAndGetReferenceCount('accounting_transfer');

         if (empty($ref_no)) {
            $prefix = ! empty($accounting_settings['transfer_prefix']) ?
               $accounting_settings['transfer_prefix'] : '';

            // Generate reference number
            $ref_no = $this->util->generateReferenceNumber('accounting_transfer', $ref_count, $business_id, $prefix);
         }

         $acc_trans_mapping = new AccountingAccTransMapping();
         $acc_trans_mapping->business_id = $business_id;
         $acc_trans_mapping->ref_no = $ref_no;
         $acc_trans_mapping->note = 'loan disbusrement';
         $acc_trans_mapping->type = 'transfer';
         $acc_trans_mapping->created_by = $user_id;
         $acc_trans_mapping->operation_date = $date;
         $acc_trans_mapping->save();

         $from_transaction_data = [
            'acc_trans_mapping_id' => $acc_trans_mapping->id,
            'amount' => ($this->util->num_uf($amount)),
            'type' => 'debit',
            'sub_type' => 'transfer',
            'accounting_account_id' => $from_account,
            'created_by' => $user_id,
            'operation_date' => $date,
         ];

         $to_transaction_data = $from_transaction_data;
         $to_transaction_data['accounting_account_id'] = $to_account;
         $to_transaction_data['amount'] = $this->util->num_uf($amount);
         $to_transaction_data['type'] = 'credit';

         AccountingAccountsTransaction::create($from_transaction_data);
         AccountingAccountsTransaction::create($to_transaction_data);

         DB::commit();

         return true;
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
   
   public function loanRepaymentStore($loanAmount,$memberloanAcc,$loanRepaymentAcc)
   {
      // Initialize AccountingUtil
      $accountingUtil = new AccountingUtil();
         try{
            $creditData = [
               'amount' => $accountingUtil->num_uf($loanAmount),
               'accounting_account_id' => $memberloanAcc,
               'created_by' => auth()->user()->id,
               'operation_date' => now(),
               'type' => 'credit',
               'sub_type' => 'payment',
               'note' => "{$fee->name} fees paid by savings account"
            ];
            AccountingAccountsTransaction::create($creditData);
            // Record debit transaction to the savings account
            $debitData = [
               'amount' => $accountingUtil->num_uf($loanAmount),
               'accounting_account_id' =>  $loanRepaymentAcc,
               'created_by' => auth()->user()->id,
               'operation_date' => now(),
               'type' => 'debit',
               'sub_type' => 'payment',
               'note' => "{$fee->name} fees paid by savings account"
            ];
            AccountingAccountsTransaction::create($debitData);
         } catch (\Exception $e) {
            // Log the error
            Log::error("Error processing fee payment by savings account: {$e->getMessage()}", [
               'time' => now()
            ]);
         }
   
   }

}
