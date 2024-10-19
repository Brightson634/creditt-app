<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Loan;
use App\Models\Plan;
use App\Models\Member;
use App\Models\Saving;
use App\Models\LoanType;
use App\Models\LoanProduct;
use App\Models\LoanDocument;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\CollateralItem;
use App\Models\LoanCollateral;
use App\Models\MemberNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
    return view('member.loans.index', compact('page_title', 'loans'));
  }

  public function loanCreate()
  {
    $page_title = 'New Loan Application';
    $loan_no = generateLoanNumber();
    $collateral_items = CollateralItem::all();
    $members = Member::where('member_type', 'individual')->get();
    $groups = Member::where('member_type', 'group')->get();
    $fees = Fee::all();
    $loanproducts = LoanProduct::all();
    return view('member.loans.create', compact(
      'page_title',
      'loan_no',
      'members',
      'groups',
      'loanproducts',
      'fees',
      'collateral_items'
    ));
  }

  // public function loanStore(Request $request)
  // {
  //   $validator = Validator::make($request->all(), [
  //     'request_amount'   => 'required|numeric',
  //     'type_id'     => 'required',
  //     'reason'     => 'required'
  //   ], [
  //     'request_amount.required'     => 'The loan request amount is required.',
  //     'request_amount.numeric'     => 'The request amount should be a value',
  //     'type_id.required'       => 'The loan type is required',
  //     'reason.required'  => 'The loan request reason is required',

  //   ]);

  //   if ($validator->fails()) {
  //     return response()->json([
  //       'status' => 400,
  //       'message' => $validator->errors()
  //     ]);
  //   }

  //   $loan = new Loan();
  //   $loan->loan_no = generateLoanNumber();
  //   $loan->member_id = member()->id;
  //   $loan->type_id = $request->type_id;
  //   $loan->request_amount = $request->request_amount;
  //   $loan->request_date = date('Y-m-d');
  //   $loan->reason = $request->reason;
  //   $loan->save();

  //   $memberNotification = new MemberNotification();
  //   $memberNotification->member_id = member()->id;
  //   $memberNotification->type = 'LOAN';
  //   $memberNotification->title = 'Loan Request';
  //   $memberNotification->detail = 'Your have requested a loan amount of ' . showAmount($request->request_amount);
  //   $memberNotification->url = NULL;
  //   $memberNotification->save();

  //   $notify[] = ['success', 'Loan Request submitted Successfully!'];
  //   session()->flash('notify', $notify);

  //   return response()->json([
  //     'status' => 200,
  //     'url' => route('member.loans')
  //   ]);
  // }

  public function loanStore(Request $request)
  {
  
     $rules = [
        'loan_type'              => 'required',
        'loanproduct_id'         => 'required',
        'principal_amount'       => 'required',
        'loan_period'            => 'required',
     ];

     $messages = [
        'loan_type.required'             => 'The loan type are required.',
        'loanproduct_id.required'        => 'The loan product are required',
        'principal_amount.required'      => 'The principal amount is required',
        'loan_period.required'           => 'The  period is required',
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

     $validator = Validator::make($request->all(), $rules, $messages);
     if ($validator->fails()) {
        return response()->json([
           'status' => 400,
           'message' => $validator->errors()
        ]);
     }


     $existingLoan = Loan::where('loan_no', $request->loan_no)->first();
     if ($existingLoan) {
        return response()->json([
           'status' => 422,
           'message' => 'A loan with this loan number already exists.',
        ]);
     }

     try {
        DB::beginTransaction();
        // Save the loan application
        $loan = new Loan();
        $loan->loan_no                = $request->loan_no;
        $loan->loan_type              = $request->loan_type;
        $loan->member_id              = ($request->loan_type == 'individual') ? $request->loan_member_id : $request->group_id;

        $loan->principal_amount       = $request->principal_amount;
        $loan->loanproduct_id         = $request->loanproduct_id;
        $loan->loan_period            = $request->loan_period;
        $loan->interest_amount        = $request->interest_amount;
        $loan->repayment_amount       = $request->repayment_amount;
        $loan->balance_amount         = $request->balance_amount;
        $loan->end_date               = $request->end_date;
        $loan->loan_principal         = ($request->payment_mode == 'loan') ? $request->loan_principal : 0;
        $loan->staff_id               = 0;
        $loan->status                 = 9;//loan application made by member
        $loan->save();
     

        $hasCollateralItems = !empty(array_filter($request->collateral_item));

        if ($hasCollateralItems) {
           foreach ($request->collateral_item as $index => $item) {
              if (!empty($item)) {
                 $collateral = new LoanCollateral();
                 $collateral->loan_id = $loan->id;
                 $collateral->collateral_item_id = $item;
                 $collateral->name = $request->collateral_name[$index] ?? null;
                 $collateral->estimate_value = $request->estimated_value[$index] ?? null;
                 $collateral->remarks = $request->collateral_remarks[$index] ?? null;

                 // Initialize an array to store all the photo filenames for this collateral item
                 $photoFilenames = [];

                 // Save collateral photos for this specific collateral item
                 if ($request->hasFile("collateral_photos.$index")) {  // Using "collateral_photos[0][], [1][] etc."
                    foreach ($request->file("collateral_photos.$index") as $photo) {
                       // Generate unique file name for each photo
                       $collateral_photo = $loan->loan_no . '_collateral_photo_' . uniqid() . time() . '.' . $photo->getClientOriginalExtension();

                       // Move the file to the specified location
                       $photo->move('assets/uploads/loans', $collateral_photo);

                       // Validate file extension
                       $ext = pathinfo($collateral_photo, PATHINFO_EXTENSION);
                       $allowedExtensions = ['jpg', 'jfif', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG', 'JFIF'];
                       if (!in_array($ext, $allowedExtensions)) {
                          return response()->json([
                             'status' => 400,
                             'message' => ['collateral_photo' => 'Only these file types are allowed: ' . implode(', ', $allowedExtensions)],
                          ]);
                       }

                       // Add the filename to the array
                       $photoFilenames[] = $collateral_photo;
                    }
                 }

                 // Save photo filenames as a comma-separated string in the `photo` field
                 if (!empty($photoFilenames)) {
                    $collateral->photo = implode(',', $photoFilenames);
                 }

                 $collateral->save();
              }
           }
        }

        // Save documents
        if ($request->hasFile('photos') && count($request->file('photos')) > 0) {
           foreach ($request->file('photos') as $photo) {
              // Check if the file is not empty or invalid
              if (!$photo->isValid()) {
                 return response()->json([
                    'status' => 400,
                    'message' => ['photo' => 'One or more uploaded files are invalid.'],
                 ]);
              }

              // Generate a unique file name for each document photo
              $photoName = $loan->loan_no . '_document_' . uniqid() . time() . '.' . $photo->getClientOriginalExtension();

              // Move the document to the specified location
              $photo->move('assets/uploads/loans', $photoName);

              // Validate the file extension
              $ext = pathinfo($photoName, PATHINFO_EXTENSION);
              $allowedExtensions = ['jpg', 'jfif', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG', 'JFIF'];
              if (!in_array($ext, $allowedExtensions)) {
                 return response()->json([
                    'status' => 400,
                    'message' => ['photo' => 'Only these file types are allowed: ' . implode(', ', $allowedExtensions)],
                 ]);
              }

              // Create a new LoanDocument entry for each uploaded photo
              $loanDocument = new LoanDocument();
              $loanDocument->loan_id = $loan->id;
              $loanDocument->member_id = ($request->loan_type == 'individual') ? $request->loan_member_id : $request->group_id;
              $loanDocument->photo = $photoName;  // Store the filename in the `photo` column
              $loanDocument->save();
           }
        }


        DB::commit();
        // Prepare the response data
        $response = response()->json([
           'status' => 200,
           'url' => route('member.dashboard',['id' => member()->member_no]),
        ]);

        $memberNotification = new MemberNotification();
        $memberNotification->member_id = member()->id;
        $memberNotification->type = 'LOAN';
        $memberNotification->title = 'Loan Application';
        $memberNotification->detail = 'Your have requested a loan amount of ' . showAmount($request->loan_principal);
        $memberNotification->url = NULL;
        $memberNotification->save();

        $notify[] = ['success', 'Loan Application Submitted!'];
        session()->flash('notify', $notify);
        return $response;
     } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to Create Loan Application: ' . $e->getMessage(), [
           'error' => $e->getMessage(),
           'data' => $request->all(),
           'trace' => $e->getTraceAsString(),
        ]);
        return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
     }
  }

}
