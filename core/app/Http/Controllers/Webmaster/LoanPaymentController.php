<?php

namespace App\Http\Controllers\Webmaster;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Setting;
use App\Utilities\Util;
use App\Models\LoanPlan;
use App\Models\SavingYear;
use App\Models\LoanPayment;
use App\Models\StaffMember;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Utils\AccountingUtil;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use App\Models\LoanRepaymentSchedule;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
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
      $entityInfo =  Session::get('tenant');
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
      $entityInfo =  Session::get('tenant');
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
      $validatedData = $request->validate([
         'proof_of_payment' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
         'amount' => 'required|numeric',
         'date_due' => 'required|date',
         'payment_date' => 'required|date',
         'payment_type' => 'required|string',
         'payment_mode' => 'required|string',
      ]);

      // return response()->json($request);

      try {
         // Handle file upload
         $filePath = null;
         if ($request->hasFile('proof_of_payment')) {
               $file = $request->file('proof_of_payment');
               $fileName = 'payment_proof_' . uniqid() . '.' . $file->getClientOriginalExtension();
               $filePath = 'assets/uploads/loans/' . $fileName;
               $file->move(public_path('assets/uploads/loans'), $fileName);
         }

         $dueDate = Carbon::parse($validatedData['date_due'])->format('Y-m-d');
         $schedule = LoanRepaymentSchedule::where('member_id', $request->memberId)
               ->whereDate('due_date', $dueDate)
               ->first();

         if (!$schedule) {
               return response()->json([
                  'success' => false,
                  'message' => 'Repayment schedule not found for the given due date.'
               ], 404);
         }

         $loan = Loan::find($schedule->loan_id);
         $memberLoanAccName = $loan->loan_no;

         DB::beginTransaction();

        // Store accounting transaction with payment date
        $this->loanRepaymentStore(
            $validatedData['amount'],
            $memberLoanAccName,
            $request->loan_account,
            $loan,
            $validatedData['payment_date']
        );
         // Update schedule
         $schedule->amount_paid = $validatedData['amount'];
         $schedule->payment_status = $validatedData['payment_type'];
         $schedule->payment_date = $validatedData['payment_date'];
         $schedule->payment_mode = $validatedData['payment_mode'];
         $schedule->balance_amount = $schedule->amount_due - $validatedData['amount'];
         $schedule->proof_of_payment = $filePath;
         $schedule->is_verified_payment = true;
         $schedule->verified_by = webmaster()->id;
         $schedule->added_by = webmaster()->id;
         $schedule->save();

         // Update loan
         $loan->repaid_amount += $validatedData['amount'];
         $loan->repayment_amount -= $validatedData['amount'];
         $loan->loan_due_date = $this->getNextDate($request->date_due_confirm) ?? $loan->loan_due_date;
         $loan->balance_amount = $loan->repayment_amount;
         $loan->payment_status = 'in_progress';
         $loan->pstatus = 1;
         $loan->last_payment_date = $schedule->due_date;
         $loan->save();

         DB::commit();

         // Render receipt view as HTML
         $receiptHtml = view('webmaster.loans.receipt', [
               'loan' => $loan,
               'dueDate' => $dueDate,
               'amount' => $validatedData['amount'],
               'paymentDate' => $validatedData['payment_date']
         ])->render();

         return response()->json([
               'success' => true,
               'message' => 'Payment saved successfully!',
               'receipt' => $receiptHtml
         ]);

      } catch (\Exception $e) {
         DB::rollBack();
         Log::error("Error confirming loan payment: {$e->getMessage()}", ['time' => now()]);

         return response()->json([
               'success' => false,
               'message' => 'There was an error confirming the loan payment.',
               'error' => $e->getMessage()
         ], 500);
      }
   }

   public function printReceipt(Request $request){
       $dueDate = Carbon::parse($request->date_due)->format('Y-m-d');
         $schedule = LoanRepaymentSchedule::where('member_id', $request->memberId)
               ->whereDate('due_date', $dueDate)
               ->first();

         if (!$schedule) {
               return response()->json([
                  'success' => false,
                  'message' => 'Repayment schedule not found for the given due date.'
               ], 404);
         }

         $loan = Loan::find($schedule->loan_id);
         
         // Render receipt view as HTML
         $receiptHtml = view('webmaster.loans.receipt', [
               'loan' => $loan,
               'dueDate' => $dueDate,
               'amount' =>  $schedule['amount_paid'],
               'paymentDate' => $schedule['payment_date']
         ])->render();

         return response()->json([
               'success' => true,
               'message' => 'Payment saved successfully!',
               'receipt' => $receiptHtml
         ]);
   }

   public function loanPaymentConfirm(Request $request)
   {
      $dueDate = Carbon::parse($request->date_due_confirm)->format('Y-m-d');
      $schedule = LoanRepaymentSchedule::where('member_id', $request->memberIdConfirm)
         ->whereDate('due_date', $dueDate)
         ->first();

      if (!$schedule) {
         return redirect()->back()->withErrors(['error' => 'Repayment schedule not found for the given due date.']);
      }

      $loan = Loan::find($schedule->loan_id);
      $memberLoanAccName = $loan->loan_no;

      DB::beginTransaction();

      try {
         $this->loanRepaymentStore($schedule->amount_paid, $memberLoanAccName, $request->loan_account_confirm,$loan);

         // Update the schedule as verified
         $schedule->is_verified_payment = true;
         $schedule->verified_by = webmaster()->id;
         $schedule->save();

         // Update loan details
         $loan->repaid_amount += $schedule->amount_paid;
         $loan->repayment_amount -= $schedule->amount_paid;
         $loan->loan_due_date = $this->getNextDate($request->date_due_confirm) ?? $loan->loan_due_date;
         $loan->balance_amount = $loan->repayment_amount;
         $loan->payment_status = 'in_progress';
         $loan->pstatus = 1;
         $loan->last_payment_date = $schedule->due_date;
         $loan->save();

         DB::commit();
         $notify[] = ['success', 'Payment Verified!'];
         session()->flash('notify', $notify);
         return redirect()->back()->with('success', 'Payment Verified');
      } catch (\Exception $e) {
         DB::rollBack();
         Log::error("Error confirming loan payment: {$e->getMessage()}", [
            'time' => now()
         ]);
         return redirect()->back()->withErrors(['error' => 'There was an error confirming the loan payment.']);
      }
   }

   public function getNextDate($givenDate)
   {
      $nextSchedule = LoanRepaymentSchedule::where('due_date', '>', Carbon::parse($givenDate))
         ->orderBy('due_date', 'asc')
         ->first();

      return $nextSchedule ? $nextSchedule->due_date : null;
   }

   // public function loanRepayment($loanAmount,$memberloanAcc,$loanRepaymentAcc)
   // {
   //    $business_id = request()->attributes->get('business_id');
   //    $accountingUtil = new AccountingUtil();
   //    $util = new Util();
   //    try {
   //       DB::beginTransaction();

   //       $user_id = webmaster()->id;
   //       $date = Carbon::now()->format('Y-m-d H:i:s');
   //       $accounting_settings = $accountingUtil->getAccountingSettings($business_id);
   //       $ref_no = '';
   //       $ref_count = $util->setAndGetReferenceCount('accounting_transfer');

   //       if (empty($ref_no)) {
   //          $prefix = ! empty($accounting_settings['transfer_prefix']) ?
   //             $accounting_settings['transfer_prefix'] : '';

   //          // Generate reference number
   //          $ref_no = $util->generateReferenceNumber('accounting_transfer', $ref_count, $business_id, $prefix);
   //       }

   //       $acc_trans_mapping = new AccountingAccTransMapping();
   //       $acc_trans_mapping->business_id = $business_id;
   //       $acc_trans_mapping->ref_no = $ref_no;
   //       $acc_trans_mapping->note = 'loan repayment';
   //       $acc_trans_mapping->type = 'transfer';
   //       $acc_trans_mapping->created_by = $user_id;
   //       $acc_trans_mapping->operation_date = $date;
   //       $acc_trans_mapping->save();

   //      $debit_data = [
   //          'acc_trans_mapping_id' => $acc_trans_mapping->id,
   //          'amount' => ($util->num_uf($amount)),
   //          'type' => 'debit',
   //          'sub_type' => 'transfer',
   //          'accounting_account_id' => $from_account,
   //          'created_by' => $user_id,
   //          'operation_date' => $date,
   //       ];

   //       $to_transaction_data =$debit_data;
   //       $to_transaction_data['accounting_account_id'] = $to_account;
   //       $to_transaction_data['amount'] = $util->num_uf($amount);
   //       $to_transaction_data['type'] = 'credit';

   //       AccountingAccountsTransaction::create($from_transaction_data);
   //       AccountingAccountsTransaction::create($to_transaction_data);

   //       DB::commit();

   //       return true;
   //    } catch (\Exception $e) {
   //       DB::rollBack();
   //       \Log::emergency('File:' . $e->getFile() . ' Line:' . $e->getLine() . ' Message:' . $e->getMessage());

   //       return response()->json([
   //          'success' => 0,
   //          'code' => 500,
   //          'msg' => 'Something went wrong: ' . $e->getMessage(),
   //       ], 500);
   //    }
   // }

   public function loanRepaymentStore($loanAmount, string $memberLoanAcc, int $loanRepaymentAcc, $loan, $paymentDate = null)
   {
      $accountingUtil = new AccountingUtil();
      DB::beginTransaction();

      try {
         $memberLoanAccId = AccountingAccount::where('name', $memberLoanAcc)->value('id');

         // Ensure valid date: fallback to now if not provided
         $operationDate = !empty($paymentDate)
               ? Carbon::parse($paymentDate)->format('Y-m-d')
               : now()->format('Y-m-d');

         // Credit Loan Account (reduces receivable)
         AccountingAccountsTransaction::create([
               'amount' => $accountingUtil->num_uf($loanAmount),
               'accounting_account_id' => $memberLoanAccId,
               'created_by' => auth()->user()->id,
               'operation_date' => $operationDate,
               'type' => 'credit',
               'loan_id' => $loan->id,
               'sub_type' => 'loan_payment',
               'note' => "Loan repayment for {$loan->loan_no}",
         ]);

         // Debit Repayment Account (increases cash/bank)
         AccountingAccountsTransaction::create([
               'amount' => $accountingUtil->num_uf($loanAmount),
               'accounting_account_id' => $loanRepaymentAcc,
               'created_by' => auth()->user()->id,
               'operation_date' => $operationDate,
               'type' => 'debit',
               'loan_id' => $loan->id,
               'sub_type' => 'loan_payment',
               'note' => "Loan repayment received for {$loan->loan_no}",
         ]);

         DB::commit();
      } catch (\Exception $e) {
         DB::rollBack();
         Log::error("Error processing loan repayment: {$e->getMessage()}", [
               'time' => now(),
         ]);
      }
   }


   public function loanRepaymentIndex(Request $request)
   {
       $tenantId = (Session::get('tenant'))['id'];
      $repayments = LoanRepaymentSchedule::with('member','loan.account')
            ->whereIn('payment_status', ['paid', 'partial'])
            ->whereHas('member', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            });
               // return response()->json($repayments->get());
      if ($request->ajax()) {

          return DataTables::of($repayments)
               ->addColumn('member', function($repayment){
                  return $repayment->member?->full_name ?? '-';
               })
               ->addColumn('loan_number', function($repayment){
                  return $repayment->loan->loan_no;
               })
               ->addColumn('loan_due_date', function($repayment){
                     return \Carbon\Carbon::parse($repayment->due_date)->format('Y-m-d');
               })
               ->addColumn('loan_amount_due', function($repayment){
                  return number_format($repayment->amount_due, 2);
               })
               ->addColumn('amount_paid', function($repayment){
                  return number_format($repayment->amount_paid, 2);
               })
               ->addColumn('payment_status', function($repayment) {
                  $status = strtolower($repayment->payment_status);
                  $badgeClass = '';

                  switch ($status) {
                     case 'paid':
                           $badgeClass = 'badge-success';
                           break;
                     case 'partial':
                           $badgeClass = 'badge-warning';
                           break;
                     case 'pending':
                     default:
                           $badgeClass = 'badge-secondary';
                           break;
                  }

                  return '<span class="badge '.$badgeClass.' text-capitalize">'.e($status).'</span>';
               })
               ->addColumn('paid_on', function($repayment){
                     return $repayment->payment_date 
                        ? \Carbon\Carbon::parse($repayment->payment_date)->format('Y-m-d') 
                        : '-';
                  })
              ->addColumn('action', function($repayment) {
                        // Start dropdown
                        $html = '
                        <div class="dropdown">
                           <button class="btn btn-sm btn-primary dropdown-toggle" 
                                    type="button" 
                                    id="actionMenu'.$repayment->id.'" 
                                    data-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false">
                                 <i class="fas fa-cogs mr-1"></i> Actions
                           </button>
                           <div class="dropdown-menu" aria-labelledby="actionMenu'.$repayment->id.'">';

                        // Conditional Map/Edit Mapping link
                        if (auth()->user()->can('edit_accounting_transactions')) {
                           $is_mapped = AccountingAccountsTransaction::where('loan_id', $repayment->loan_id)
                                             ->where('operation_date', $repayment->payment_date)
                                             ->exists();

                           $dataAcc = $repayment->loan?->account?->id ?? '';

                           if (!$is_mapped) {
                                 $html .= '
                                 <a href="#" 
                                    data-href="'.action([\App\Http\Controllers\Webmaster\TransactionController::class, 'map']).'?id='.$repayment->loan_id.'&type=loan_payment'.'" 
                                    class="dropdown-item map_transaction" 
                                    data-date="'.$repayment->payment_date.'" 
                                    data-acc="'.$dataAcc.'">
                                    <i class="fas fa-link mr-2 text-primary"></i> '.__('Map Transaction').'
                                 </a>';
                           } else {
                                 $html .= '
                                 <a href="#" 
                                    data-href="'.action([\App\Http\Controllers\Webmaster\TransactionController::class, 'map']).'?id='.$repayment->loan_id.'&type=loan_payment'.'" 
                                    class="dropdown-item map_transaction text-warning" 
                                    data-date="'.$repayment->payment_date.'" 
                                    data-acc="'.$dataAcc.'">
                                    <i class="fas fa-edit mr-2"></i> '.__('Edit Mapping').'
                                 </a>';
                           }
                        }

                        // Close dropdown
                        $html .= '</div></div>';

                        return $html;
                     })

                  ->rawColumns(['action','payment_status'])
               ->make(true);
       }


   }

}