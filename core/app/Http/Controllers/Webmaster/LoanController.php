<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Loan;
use App\Models\Member;
use App\Models\MemberAccount;
use App\Models\Group;
use App\Models\Fee;
use App\Models\FeeRange;
use App\Models\Statement;
use App\Models\StaffMember;
use App\Models\Role;
use App\Models\LoanProduct;
use App\Models\LoanCollateral;
use App\Models\LoanGuarantor;
use App\Models\LoanRepayment;
use App\Models\LoanDocument;
use App\Models\CollateralItem;
use App\Models\LoanCharge;
use App\Models\LoanOfficer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;

class LoanController extends Controller
{
   public function __construct()
   { 
     $this->middleware('auth:webmaster');
   }

   public function loans()
   {
      $page_title = 'Loans';
      $data['pendingloans'] = Loan::where('status', 0)->get();
      $data['reviewloans'] = Loan::where('status', 1)->get();
      $data['approvedloans'] = Loan::where('status', 2)->get();
      $data['rejectloans'] = Loan::where('status', 3)->get();
      return view('webmaster.loans.index', compact('page_title', 'data'));
   }

   public function myloans()
   {
      $page_title = 'My Loans';
      // $loans = Loan::whereIn('officer_id', webmaster()->id)->get();
      //$authorize_ids = explode(',', $loan->authorize_id);
      //$officers = \App\Models\LoanOfficer::whereIn('staff_id', $authorize_ids)->get();

      $staffID = webmaster()->id;
      //$loans = Loan::whereRaw("FIND_IN_SET(?, officer_id)", [$staffID])->get();
      $loans = Loan::whereRaw("SUBSTRING_INDEX(officer_id, ',', 1) = ?", [$staffID])->get();
      return view('webmaster.loans.myloans', compact('page_title', 'loans'));
   }

   public function loanCreate()
   {
      $page_title = 'Add Loan';
      $loan_no = generateLoanNumber();
      $members = Member::where('member_type', 'individual')->get();
      $groups = Member::where('member_type', 'group')->get();
      $fees = Fee::all();
      $loanproducts = LoanProduct::all();
      return view('webmaster.loans.create', compact('page_title', 'loan_no', 'members', 'groups', 'loanproducts', 'fees'));
   }

   public function loanFeesCalculate(Request $request)
   {  
      $fees = Fee::whereIn('id', $request->fees_id)->get();
      $feesTotal = 0;

      foreach ($fees as $fee) {
         if ($fee->rate_type === 'fixed') {
            $feesTotal += $fee->amount;
         } elseif ($fee->rate_type === 'percent') {
            $feesTotal += ($fee->rate_value) * $request->principal_amount;
         } elseif ($fee->rate_type === 'range') {
            $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
            foreach ($feeRanges as $range) {
               if ($request->principal_amount >= $range->min_amount && $request->principal_amount <= $range->max_amount) {
                  $feesTotal += $range->amount;
                  break;
               }
            }
         }
      }
      return response()->json(['fees_total' => $feesTotal]);
   }


   public function loanStore(Request $request)
   {
      $rules = [
        'loan_type'              => 'required',
        'loanproduct_id'         => 'required',
        'principal_amount'       => 'required',
        'loan_period'            => 'required',
        'fees_id'                => 'required',
        'payment_mode'           => 'required',
      ];

      $messages = [
         'loan_type.required'             => 'The loan type are required.',
         'loanproduct_id.required'        => 'The loan product are required',
         'principal_amount.required'      => 'The principal amount is required',
         'loan_period.required'           => 'The  period is required',
         'fees_id.required'               => 'The  fees is required',
         'payment_mode.required'          => 'The  payment mode is required'
      ];

      if ($request->loan_type == 'member') {
         $rules += [
            'member_id'        => 'required',
         ];
            
         $messages += [
            'member_id.required'    => 'The member is required'
         ];
      }

      if ($request->loan_type == 'group') {
         $rules += [
            'group_id'        => 'required',
         ];
            
         $messages += [
            'group_id.required'    => 'The group is required'
         ];
      }

      if ($request->payment_mode == 'cash') {
         $rules += [
            'cash_amount'        => 'required',
         ];
            
         $messages += [
            'cash_amount.required'    => 'The cash amount required'
         ];
      }

      if ($request->payment_mode == 'savings') {
         $rules += [
            'account_id'        => 'required',
         ];
            
         $messages += [
            'account_id.required'    => 'The savings account is required'
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }
         
      $loan = new Loan();
      $loan->loan_no                = $request->loan_no;
      $loan->loan_type              = $request->loan_type;
      $loan->member_id = ($request->loan_type == 'individual') ? $request->member_id : $request->group_id;
      $loan->principal_amount       = $request->principal_amount;
      $loan->loanproduct_id         = $request->loanproduct_id;
      $loan->loan_period            = $request->loan_period;
      $loan->interest_amount        = $request->interest_amount;
      $loan->repayment_amount       = $request->repayment_amount;
      $loan->balance_amount       = $request->balance_amount;
      $loan->end_date               = $request->end_date;
      $loan->fees_id                = implode(',', $request->fees_id);
      $loan->fees_total             = $request->fees_total;
      $loan->payment_mode           = $request->payment_mode;
      $loan->cash_amount = ($request->payment_mode == 'cash') ? $request->cash_amount : 0;
      $loan->account_id = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
      $loan->loan_principal = ($request->payment_mode == 'loan') ? $request->loan_principal : 0;
      $loan->staff_id  = webmaster()->id;
      $loan->status  = 0;
      $loan->save();

      foreach ($request->fees_id as $feeId) {
         $fee = Fee::find($feeId);
         $statement = new Statement();
         $statement->member_id = $request->member_id;
         $statement->account_id   = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
         $statement->type = 'LOAN FEES';
         $statement->detail = 'Charge - ' . $fee->name;
         if ($fee->rate_type === 'fixed') {
            $statement->amount = $fee->amount;
         } elseif ($fee->rate_type === 'percent') {
            $statement->amount = $fee->rate_value * $request->principal_amount;
         } elseif ($fee->rate_type === 'range') {
            $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
            foreach ($feeRanges as $range) {
               if ($request->principal_amount >= $range->min_amount && $request->principal_amount <= $range->max_amount) {
                  $statement->amount = $range->amount;
                  break;
               }
            }
         }
         $statement->status = 0;
         $statement->save();

         if ($request->payment_mode == 'savings') {
            $memberaccount = MemberAccount::where('id', $request->account_id)->first();
            $memberaccount->available_balance -= $request->fees_total;
            $memberaccount->save();
         }

         $charge = new LoanCharge();
         $charge->loan_id = $loan->id;
         $charge->account_id   = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
         $charge->type = 'LOAN FEES';
         $charge->detail = 'Charge - ' . $fee->name;
         if ($fee->rate_type === 'fixed') {
            $charge->amount = $fee->amount;
         } elseif ($fee->rate_type === 'percent') {
            $charge->amount = $fee->rate_value * $request->principal_amount;
         } elseif ($fee->rate_type === 'range') {
            $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
            foreach ($feeRanges as $range) {
               if ($request->principal_amount >= $range->min_amount && $request->principal_amount <= $range->max_amount) {
                  $charge->amount = $range->amount;
                  break;
               }
            }
         }
         $charge->status = 0;
         $charge->save();
      }

      $notify[] = ['success', 'Loan added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.loan.dashboard', $loan->loan_no)
      ]);
   }

   public function loanDashboard($loan_no)
   {
      $page_title = 'Loan Dashboard - ' .$loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $mbrs = Member::orderBy('fname')->get();
      $guarantorMembers = LoanGuarantor::where('is_member', 1)->pluck('member_id')->toArray();
      $members = $mbrs->whereNotIn('id', $guarantorMembers);
      $collateral_items = CollateralItem::all();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $repayments = LoanRepayment::where('loan_id', $loan->id)->get();
      $documents = LoanDocument::where('loan_id', $loan->id)->get();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $roles = Role::all();
      $staffs = StaffMember::all();
      $officers = LoanOfficer::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.dashboard', compact('page_title', 'loan', 'members', 'collaterals', 'guarantors', 'repayments', 'collateral_items', 'documents', 'loancharges', 'staffs', 'officers', 'roles'));
   }

   public function loanStaff($id)
   {
      $staffs = StaffMember::where('id', $id)->get();
      if ($staffs->isEmpty()) {
        return response()->json('<option value="">No staff found</option>');
      }

      $optionsHtml = '<option value="">select staff member</option>';
      foreach ($staffs as $staff) {
         $optionsHtml .= '<option value="' . $staff->id . '">' . $staff->fname . '</option>';
      }
      return response()->json($optionsHtml);
   }

   public function staffAssign(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'role_id'    => 'required',
        'staff_id'   => 'required',
      ], [
        'role_id.required'    => 'please select the role',
        'staff_id.required'   => 'please select the staff member',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $loan = Loan::find($request->loan_id);
      $existing_officers = explode(',', ltrim($loan->officer_id, ','));
      if (!in_array($request->staff_id, $existing_officers)) {
         $existing_officers[] = $request->staff_id;
      }
      $loan->officer_id = implode(',', $existing_officers);
      $loan->save();

      $officer = new LoanOfficer();
      $officer->loan_id = $request->loan_id;
      $officer->role_id = $request->role_id;
      $officer->staff_id = $request->staff_id;
      $officer->save();

      $notify[] = ['success', 'Loan Officer uploaded successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
      ]);

   }

   public function loanPreview($loan_no)
   {
      $page_title = 'Review Loan - ' .$loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.preview', compact('page_title', 'loan', 'loancharges', 'guarantors', 'collaterals'));
   }

   public function loanReviewEdit($loan_no)
   {
      $page_title = 'Loan Preview - ' .$loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.review', compact('page_title', 'loan', 'loancharges', 'guarantors', 'collaterals'));
   }

   public function loanReviewUpdate(Request $request)
   {
      $loan = Loan::find($request->id);
      $loan->status = 1;
      $loan->save();
         
      $notify[] = ['success', 'Loan Submitted for Review'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   public function loanReviewStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'notes'        => 'required',
      ], [
         'notes.required' => 'The loan notes is required.',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $staff_id = webmaster()->id;

      $loan = Loan::find($request->loan_id);
      $existing_officers = explode(',', ltrim($loan->authorize_id, ','));
      if (!in_array($staff_id, $existing_officers)) {
         $existing_officers[] = $staff_id;
      }
      $loan->authorize_id = implode(',', $existing_officers);


      $existing_staffs = explode(',', $loan->officer_id);
      $index = array_search($staff_id, $existing_staffs);
      if ($index !== false) {
         unset($existing_staffs[$index]);
      }
      $existing_staffs = array_values($existing_staffs);
      $loan->officer_id = implode(',', $existing_staffs);
      $loan->status = $request->status;
      $loan->save();



      $officer = LoanOfficer::where('loan_id', $request->loan_id)->where('staff_id', $staff_id)->first();
      $officer->comment = $request->notes;
      $officer->date = date('Y-m-d');
      $officer->save();
         
      $notify[] = ['success', 'Loan Review updated successfully'];
      session()->flash('notify', $notify);

      return response()->json([
       'status' => 200,
        'url' => route('webmaster.myloans')
      ]);
   }

   // public function loanReviewPdf($loan_no)
   // {
   //    $title = 'Loan - #' .$loan_no;
   //    $loan = Loan::where('loan_no', $loan_no)->first();
   //    $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
   //    $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
   //    $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();

   //    $data = [
   //       'title' => $title,
   //       'loan' => $loan,
   //       'loancharges' => $loancharges,
   //       'guarantors' => $guarantors,
   //       'collaterals' => $collaterals,
   //    ];

   //    $mpdf = new Mpdf();
   //    $html = view('webmaster.loans.reviewpdf', $data);
   //    $mpdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg}');
   //    $mpdf->WriteHTML($html);
   //    $mpdf->Output('loan_review_#' . $loan_no . '.pdf', 'D');
   // }

   public function loanPrintPdf($loan_no)
   {
      $title = 'Loan - #' .$loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();

      $officers = LoanOfficer::where('loan_id', $loan->id)->get();

      $data = [
         'title'        => $title,
         'loan'         => $loan,
         'loancharges'  => $loancharges,
         'guarantors'   => $guarantors,
         'collaterals'  => $collaterals,
         'officers'     => $officers,
      ];

      $mpdf = new Mpdf();
      $html = view('webmaster.loans.reviewpdf', $data);
      $mpdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg}');
      $mpdf->WriteHTML($html);
      $mpdf->Output('loan_review_#' . $loan_no . '.pdf', 'D');
   }

   public function loanReviewPdf($loan_no)
   {
      $title = 'Loan - #' . $loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();

      $data = [
         'title' => $title,
         'loan' => $loan,
         'loancharges' => $loancharges,
         'guarantors' => $guarantors,
         'collaterals' => $collaterals,
      ];

      $mpdf = new Mpdf();
      $html = view('webmaster.loans.reviewpdf', $data);
      $mpdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg}');
      $mpdf->WriteHTML($html);
      $pdfContent = $mpdf->Output('', 'S');
      return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="loan_review_#' . $loan_no . '.pdf"');
}


   public function collateralStore(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'item_id' => 'required',
        'collateral_name' => 'required',
        'collateral_photo' => 'required|image|max:2048|mimes:jpeg,jpg,png,JPG,PNG,JPEG',
        'estimate_value' => 'required|numeric',
        'remarks' => 'required',
      ], [
         'item_id.required' => 'The collateral item is required',
         'collateral_name.required' => 'The collateral name is required',
         'collateral_photo.required' => 'The collateral photo is required',
         'collateral_photo.image' => 'The uploaded file must be an image.',
         'collateral_photo.max'   => 'The uploaded file may not be larger than 2MB.',
         'remarks.required' => 'The remarks is required',
         'estimate_value.required'       => 'The amount is required.',
         'estimate_value.numeric'        => 'The amount should be a number value',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      } 

      if ($request->hasFile('collateral_photo')) {
            $temp_name = $request->file('collateral_photo');
            $collateral_photo = $request->loan_no . 'collateral_photo' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
            $temp_name->move('assets/uploads/loans', $collateral_photo);
            $ext = pathinfo($collateral_photo, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
            if (!in_array($ext, $allowedExtensions)) {
                return response()->json([
                    'status' => 400,
                    'message' => ['collateral_photo' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
                ]);
            }
        }

        $collateral = new LoanCollateral();
        $collateral->loan_id = $request->loan_id;
        $collateral->collateral_item_id = $request->item_id;
        $collateral->member_id = $request->member_id;
        $collateral->name = $request->collateral_name;
        $collateral->photo = $collateral_photo;
        $collateral->estimate_value = $request->estimate_value;
        $collateral->remarks = $request->remarks;
        $collateral->save();

      $notify[] = ['success', 'Loan Collateral added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);

   }

   public function collateralDelete(Request $request)
   {
      $collateral = LoanCollateral::find($request->id);
      if ($collateral) {
         @unlink('assets/uploads/loans/' . $collateral->photo);
         $collateral->delete();
      }
      $notify[] = ['success', 'Loan Collateral deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }


   public function guarantorStore(Request $request)
   {
      if ($request->is_member == 1) {
         $rules['member_id'] = 'required';
         $messages['member_id.required'] = 'Please select a member';
      }

      if ($request->is_member == 0) {
         $rules = [
           'name'        => 'required',
           'email'       => 'required|email|unique:loan_guarantors',
           'telephone'   => 'required',
           'address'     => 'required',
           'occupation'     => 'required',
         ];

         $messages = [
           'name.required'         => 'The Guarantor names are required.',
           'email.required'        => 'The Guarantor email is required.',
           'email.unique'          => 'The email address is already registered',
           'telephone.required'    => 'The Telephone numbers are required',
           'address.required'      => 'The Guarantor address is required',
           'occupation.required'   => 'The Guarantor Occupation is required',
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
          return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }    

      if ($request->is_member == 1) {
         $guarantor = new LoanGuarantor();
         $guarantor->loan_id = $request->loan_id;
         $guarantor->is_member = 1;
         $guarantor->member_id = $request->member_id;
         $guarantor->save();
      }

      if ($request->is_member == 0) {
         $guarantor = new LoanGuarantor();
         $guarantor->loan_id = $request->loan_id;
         $guarantor->is_member = 0;
         $guarantor->name = $request->name;
         $guarantor->telephone = $request->telephone;
         $guarantor->email = $request->email;
         $guarantor->occupation = $request->occupation;
         $guarantor->address = $request->address;
         $guarantor->save();
      }


      $notify[] = ['success', 'Loan Guarantor added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

   }

   public function guarantorUpdate(Request $request)
   {
      $guarantor_id = $request->id;
      $rules = [
         'name'        => 'required',
         'email'       => 'required|email', //|unique:loan_guarantors',
         'telephone'   => 'required',
         'address'     => 'required',
         'occupation'     => 'required',
      ];
      $messages = [
         'name.required'         => 'The Guarantor names are required.',
         'email.required'        => 'The Guarantor email is required.',
        // 'email.unique'          => 'The email address is already registered',
         'telephone.required'    => 'The Telephone numbers are required',
         'address.required'      => 'The Guarantor address is required',
         'occupation.required'   => 'The Guarantor Occupation is required',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
          return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $guarantor = LoanGuarantor::find($guarantor_id);
      $guarantor->name = $request->name;
      $guarantor->telephone = $request->telephone;
      $guarantor->email = $request->email;
      $guarantor->occupation = $request->occupation;
      $guarantor->address = $request->address;
      $guarantor->save();
     
      $notify[] = ['success', 'Loan Guarantor updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

   }

   public function guarantorDelete(Request $request)
   {
      $guarantor_id = LoanGuarantor::find($request->id);
      if ($guarantor_id) {
         $guarantor_id->delete();
      }
      $notify[] = ['success', 'Loan Guarantor deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }


   public function documentStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'photo'                => 'required|image|max:2048|mimes:jpeg,jpg,png,JPG,PNG,JPEG',
      ], [
        'photo.required'                => 'The photo is required.',
        'photo.image'                   => 'The uploaded file must be an image.',
        'photo.max'                     => 'The uploaded file may not be larger than 2MB.',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      if ($request->hasFile('photo')) {
         $temp_name = $request->file('photo');
         $photo = $request->loan_no . 'document' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/loans', $photo);
         $ext = pathinfo($photo, PATHINFO_EXTENSION);
         $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
         if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
               'status' => 400,
               'message' => ['photo' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
            ]);
         }
      }

      $document = new LoanDocument();
      $document->loan_id = $request->loan_id;
      $document->member_id = $request->member_id;
      $document->photo = $photo;
      $document->save();

      $notify[] = ['success', 'Loan Document uploaded successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
      ]);

   }


}
