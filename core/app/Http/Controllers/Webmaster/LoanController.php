<?php

namespace App\Http\Controllers\Webmaster;

use Log;
use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Loan;
use App\Models\Group;
use App\Models\Member;

use App\Utilities\Util;
use App\Models\FeeRange;
use App\Models\Statement;
use App\Models\LoanCharge;
use App\Models\LoanOfficer;
use App\Models\LoanPayment;
use App\Models\LoanProduct;
use App\Models\StaffMember;
use App\Models\LoanDocument;
use Illuminate\Http\Request;
use App\Models\LoanGuarantor;
use App\Models\MemberAccount;
use App\Utils\AccountingUtil;
use App\Models\CollateralItem;
use App\Models\LoanCollateral;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ActivityStream;
use App\Events\LoanReviewedEvent;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Entities\AccountingAccount;
use App\Events\LoanApplicationEvent;
use App\Http\Controllers\Controller;
use App\Events\LoanApplicantEvent;
use App\Entities\AccountingAccountType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Entities\AccountingAccTransMapping;
use App\Notifications\ReviewLoanNotification;
use App\Entities\AccountingAccountsTransaction;

class LoanController extends Controller
{
   protected $activityService;
   protected $util;
   protected $accountingUtil;

   public function __construct(ActivityStream $activityService, Util $util, AccountingUtil $accountingUtil)
   {
      $this->middleware('auth:webmaster');
      $this->activityService = $activityService;
      $this->util = $util;
      $this->accountingUtil = $accountingUtil;
   }

   public function loans()
   {
      $page_title = 'Loans';
      $data['pendingloans'] = Loan::where('status', 0)->get();
      $data['reviewloans'] = Loan::where('status', 2)->get();
      $data['approvedloans'] = Loan::where('status', 3)->get();
      $data['rejectloans'] = Loan::where('status', 4)->get();
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
      //   $loans = Loan::whereRaw("SUBSTRING_INDEX(officer_id, ',', 1) = ?", [$staffID])->get();
      $loans = Loan::where('staff_id', $staffID)->get();

      //   return new JsonResponse($loans);
      return view('webmaster.loans.myloans', compact('page_title', 'loans'));
   }

   public function loanCreate()
   {
      $page_title = 'Add Loan';
      $loan_no = generateLoanNumber();
      $collateral_items = CollateralItem::all();
      $members = Member::where('member_type', 'individual')->get();
      $groups = Member::where('member_type', 'group')->get();
      $fees = Fee::all();
      $loanproducts = LoanProduct::all();
      return view('webmaster.loans.create', compact(
         'page_title',
         'loan_no',
         'members',
         'groups',
         'loanproducts',
         'fees',
         'collateral_items'
      ));
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


   // public function loanStore(Request $request)
   // {
   //    return response()->json($request);
   //    $rules = [
   //      'loan_type'              => 'required',
   //      'loanproduct_id'         => 'required',
   //      'principal_amount'       => 'required',
   //      'loan_period'            => 'required',
   //      'fees_id'                => 'required',
   //      'payment_mode'           => 'required',
   //    ];

   //    $messages = [
   //       'loan_type.required'             => 'The loan type are required.',
   //       'loanproduct_id.required'        => 'The loan product are required',
   //       'principal_amount.required'      => 'The principal amount is required',
   //       'loan_period.required'           => 'The  period is required',
   //       'fees_id.required'               => 'The  fees is required',
   //       'payment_mode.required'          => 'The  payment mode is required'
   //    ];

   //    if ($request->loan_type == 'member') {
   //       $rules += [
   //          'member_id'        => 'required',
   //       ];

   //       $messages += [
   //          'member_id.required'    => 'The member is required'
   //       ];
   //    }

   //    if ($request->loan_type == 'group') {
   //       $rules += [
   //          'group_id'        => 'required',
   //       ];

   //       $messages += [
   //          'group_id.required'    => 'The group is required'
   //       ];
   //    }

   //    if ($request->payment_mode == 'cash') {
   //       $rules += [
   //          'cash_amount'        => 'required',
   //       ];

   //       $messages += [
   //          'cash_amount.required'    => 'The cash amount required'
   //       ];
   //    }

   //    if ($request->payment_mode == 'savings') {
   //       $rules += [
   //          'account_id'        => 'required',
   //       ];

   //       $messages += [
   //          'account_id.required'    => 'The savings account is required'
   //       ];
   //    }

   //    $validator = Validator::make($request->all(), $rules, $messages);
   //    if ($validator->fails()) {
   //       return response()->json([
   //          'status' => 400,
   //          'message' => $validator->errors()
   //       ]);
   //    }

   //    $loan = new Loan();
   //    $loan->loan_no                = $request->loan_no;
   //    $loan->loan_type              = $request->loan_type;
   //    $loan->member_id = ($request->loan_type == 'individual') ? $request->member_id : $request->group_id;
   //    $loan->principal_amount       = $request->principal_amount;
   //    $loan->loanproduct_id         = $request->loanproduct_id;
   //    $loan->loan_period            = $request->loan_period;
   //    $loan->interest_amount        = $request->interest_amount;
   //    $loan->repayment_amount       = $request->repayment_amount;
   //    $loan->balance_amount       = $request->balance_amount;
   //    $loan->end_date               = $request->end_date;
   //    $loan->fees_id                = implode(',', $request->fees_id);
   //    $loan->fees_total             = $request->fees_total;
   //    $loan->payment_mode           = $request->payment_mode;
   //    $loan->cash_amount = ($request->payment_mode == 'cash') ? $request->cash_amount : 0;
   //    $loan->account_id = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
   //    $loan->loan_principal = ($request->payment_mode == 'loan') ? $request->loan_principal : 0;
   //    $loan->staff_id  = webmaster()->id;
   //    $loan->status  = 0;
   //    $loan->save();

   //    $filteredFees = array_filter($request->fees_id, function($value) {
   //    return !is_null($value);
   //    });
   //    if(!empty($filteredFees)){
   //      foreach ($filteredFees as $feeId) {
   //          $fee = Fee::find($feeId);
   //          $statement = new Statement();
   //          $statement->member_id = $request->member_id;
   //          $statement->account_id   = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
   //          $statement->type = 'LOAN FEES';
   //          $statement->detail = 'Charge - ' . $fee->name;
   //          if ($fee->rate_type === 'fixed') {
   //              $statement->amount = $fee->amount;
   //          } elseif ($fee->rate_type === 'percent') {
   //              $statement->amount = $fee->rate_value * $request->principal_amount;
   //          } elseif ($fee->rate_type === 'range') {
   //              $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
   //              foreach ($feeRanges as $range) {
   //              if ($request->principal_amount >= $range->min_amount && $request->principal_amount <= $range->max_amount) {
   //                  $statement->amount = $range->amount;
   //                  break;
   //              }
   //              }
   //          }
   //          $statement->status = 0;
   //          $statement->save();

   //          if ($request->payment_mode == 'savings') {
   //              $memberaccount = MemberAccount::where('id', $request->account_id)->first();
   //              $memberaccount->available_balance -= $request->fees_total;
   //              $memberaccount->save();
   //          }

   //          $charge = new LoanCharge();
   //          $charge->loan_id = $loan->id;
   //          $charge->account_id   = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
   //          $charge->type = 'LOAN FEES';
   //          $charge->detail = 'Charge - ' . $fee->name;
   //          if ($fee->rate_type === 'fixed') {
   //              $charge->amount = $fee->amount;
   //          } elseif ($fee->rate_type === 'percent') {
   //              $charge->amount = $fee->rate_value * $request->principal_amount;
   //          } elseif ($fee->rate_type === 'range') {
   //              $feeRanges = FeeRange::where('fee_id', $fee->id)->get();
   //              foreach ($feeRanges as $range) {
   //              if ($request->principal_amount >= $range->min_amount && $request->principal_amount <= $range->max_amount) {
   //                  $charge->amount = $range->amount;
   //                  break;
   //              }
   //              }
   //          }
   //          $charge->status = 0;
   //          $charge->save();
   //      }
   //   }

   //    $notify[] = ['success', 'Loan added Successfully!'];
   //    session()->flash('notify', $notify);

   //    return response()->json([
   //      'status' => 200,
   //      'url' => route('webmaster.loan.dashboard', $loan->loan_no)
   //    ]);
   // }

   public function loanExists(Request $request)
   {
      $loan = Loan::where('member_id', $request->member)->first();
      if ($loan) {
         $status = true;
      } else {
         $status = false;
      }
      return response()->json(['status' => $status]);
   }
   public function loanStore(Request $request)
   {
      // return response()->json($request);
      $rules = [
         'loan_type'              => 'required',
         'loanproduct_id'         => 'required',
         'principal_amount'       => 'required',
         'loan_period'            => 'required',
         'fees_id'                => 'required',
         'payment_mode'           => 'required',
         'grace_period_value' => 'required',
         'loan_maturity_date' => 'required',
      ];

      $messages = [
         'loan_type.required'             => 'The loan type are required.',
         'loanproduct_id.required'        => 'The loan product are required',
         'principal_amount.required'      => 'The principal amount is required',
         'loan_period.required'           => 'The  period is required',
         'fees_id.required'               => 'The  fees is required',
         'payment_mode.required'          => 'The  payment mode is required',
         'grace_period_value' => "The grace period value is required",
         'loan_maturity_date' => 'Loan Maturity date is required',

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


      $existingLoan = Loan::where('loan_no', $request->loan_no)->first();
      if ($existingLoan) {
         return response()->json([
            'status' => 422,
            'message' => 'A loan with this loan number already exists.',
         ]);
      }

      DB::beginTransaction();
      try {
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
         $loan->maturity_date          = Carbon::createFromFormat('d/m/Y', $request->loan_maturity_date)->format('Y-m-d');
         $loan->grace_period     = $request->grace_period_value;
         $loan->grace_period_in      = $request->grace_period_type;

         $loan->fees_id                = implode(',', $request->fees_id);
         $loan->fees_total             = $request->fees_total;
         $loan->payment_mode           = $request->payment_mode;
         $loan->cash_amount            = ($request->payment_mode == 'cash') ? $request->cash_amount : 0;
         $loan->account_id             = ($request->payment_mode == 'savings') ? $request->account_id : NULL;
         $loan->loan_principal         = ($request->payment_mode == 'loan') ? $request->loan_principal : 0;
         $loan->staff_id               = webmaster()->id;
         $loan->status                 = 0;
         $loan->save();

         //create loan account
         $this->createMemberLoanInCOA($request->loan_no, $request->parent_id);


         //  try {
         //    $loan->save();
         //  } catch (\Exception $e) {
         //    return response()->json($e->getMessage());
         //  }

         $filteredFees = array_filter($request->fees_id, function ($value) {
            return !is_null($value);
         });


         if (!empty($filteredFees)) {
            foreach ($filteredFees as $feeId) {
               $fee = Fee::find($feeId);
               $statement = new Statement();
               $statement->member_id = $request->loan_member_id;
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
         }

         // Save guarantors
         if ($request->is_member) {
            foreach ($request->member_id as $member_id) {
               $guarantor = new LoanGuarantor();
               $guarantor->is_member = 1;
               $guarantor->member_id = $member_id;
               $guarantor->loan_id = $loan->id;
               $guarantor->save();
            }
         } else {
            foreach ($request->non_member_names as $index => $name) {
               if (!empty($name)) {
                  $guarantor = new LoanGuarantor();
                  $guarantor->name = $name;
                  $guarantor->telephone = $request->non_member_telephones[$index] ?? null;
                  $guarantor->email = $request->non_member_emails[$index] ?? null;
                  $guarantor->loan_id = $loan->id;
                  $guarantor->occupation = $request->non_member_occupations[$index] ?? null;
                  $guarantor->address = $request->non_member_addresses[$index] ?? null;
                  $guarantor->save();
               }
            }
         }

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
            'url' => route('webmaster.loan.dashboard', $loan->loan_no),
         ]);

         register_shutdown_function(function () use ($loan) {
            event(new LoanApplicantEvent($loan)); //notify applicant on loan status
            event(new LoanApplicationEvent($loan)); //notify reviewers
         });

         // Log activity and set flash messages
         ActivityStream::logActivity(webmaster()->id, 'New Loan', 0, $loan->loan_no);
         $notify[] = ['success', 'Loan added Successfully!'];
         session()->flash('notify', $notify);
         return $response;
      } catch (\Exception $e) {
         DB::rollBack();
         return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
      }
   }

   function createMemberLoanInCOA($accName, $accSubTypeId, $openBalance = 0)
   {

      $business_id = request()->attributes->get('business_id');
      $user_id = (request()->attributes->get('user'))->id;
      try {
         DB::beginTransaction();

         $account_type = AccountingAccountType::find($accSubTypeId);


         $dataUserAcc['name'] = $accName;
         $dataUserAcc['account_primary_type'] = $account_type->account_primary_type;
         $dataUserAcc['account_sub_type_id'] = $accSubTypeId;
         $dataUserAcc['created_by'] = $user_id;
         $dataUserAcc['business_id'] = $business_id;
         $dataUserAcc['status'] = 'active';

         $account = AccountingAccount::create($dataUserAcc);

         if ($account_type->show_balance == 1 && ! empty($openBalance)) {
            //Opening balance
            $data = [
               'amount' => $openBalance,
               'accounting_account_id' => $account->id,
               'created_by' => auth()->user()->id,
               'operation_date' => \Carbon\Carbon::today()->format('Y-m-d'),
            ];
            //Opening balance
            $data['type'] = in_array($account_type->account_primary_type, ['asset', 'expenses']) ? 'debit' : 'credit';
            $data['sub_type'] = 'opening_balance';
            AccountingAccountsTransaction::createTransaction($data);
         }

         DB::commit();

         return true;
      } catch (\Exception $e) {
         DB::rollBack();

         Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
         return false;
      }
   }

   // public function store(Request $request)
   // {
   //     // Validate the request
   //     $validator = Validator::make($request->all(), [
   //         'loan_no' => 'required|string|max:255',
   //         'loan_type' => 'required|in:individual,group',
   //         'member_id' => 'required_if:loan_type,individual|exists:members,id',
   //         'group_id' => 'required_if:loan_type,group|exists:groups,id',
   //         'principal_amount' => 'required|numeric',
   //         'loanproduct_id' => 'required|exists:loan_products,id',
   //         'loan_period' => 'required|numeric',
   //         'interest_amount' => 'required|numeric',
   //         'repayment_amount' => 'required|numeric',
   //         'end_date' => 'required|date',
   //         'loan_maturity_date' => 'required|date',
   //         'grace_period_type' => 'required|in:days,weeks,months',
   //         'grace_period_value' => 'nullable|numeric',
   //         'fees_id' => 'required|array',
   //         'fees_total' => 'required|numeric',
   //         'payment_mode' => 'required|in:cash,savings,loan',
   //         'cash_amount' => 'nullable|numeric',
   //         'account_id' => 'nullable|exists:accounts,id',
   //         'loan_principal' => 'nullable|numeric',
   //         'is_member' => 'required|boolean',
   //         'member_id.*' => 'nullable|exists:members,id',
   //         'non_member_names.*' => 'nullable|string|max:255',
   //         'non_member_emails.*' => 'nullable|email',
   //         'non_member_telephones.*' => 'nullable|string',
   //         'non_member_occupations.*' => 'nullable|string',
   //         'non_member_addresses.*' => 'nullable|string',
   //         'collateral_item.*' => 'nullable|exists:collateral_items,id',
   //         'collateral_name.*' => 'nullable|string|max:255',
   //         'estimated_value.*' => 'nullable|numeric',
   //         'collateral_remarks.*' => 'nullable|string',
   //         'collateral_photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
   //         'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
   //     ]);

   //     if ($validator->fails()) {
   //         return redirect()->back()->withErrors($validator)->withInput();
   //     }

   //     DB::beginTransaction();

   //     try {
   //         // Save loan application
   //         $loan = Loan::create([
   //             'loan_no' => $request->loan_no,
   //             'loan_type' => $request->loan_type,
   //             'member_id' => $request->loan_type === 'individual' ? $request->member_id : null,
   //             'group_id' => $request->loan_type === 'group' ? $request->group_id : null,
   //             'principal_amount' => $request->principal_amount,
   //             'loanproduct_id' => $request->loanproduct_id,
   //             'loan_period' => $request->loan_period,
   //             'interest_amount' => $request->interest_amount,
   //             'repayment_amount' => $request->repayment_amount,
   //             'end_date' => $request->end_date,
   //             'loan_maturity_date' => $request->loan_maturity_date,
   //             'grace_period_type' => $request->grace_period_type,
   //             'grace_period_value' => $request->grace_period_value,
   //             'fees_total' => $request->fees_total,
   //             'payment_mode' => $request->payment_mode,
   //             'cash_amount' => $request->cash_amount,
   //             'account_id' => $request->account_id,
   //             'loan_principal' => $request->loan_principal,
   //             'is_member' => $request->is_member,
   //         ]);

   //         // Save guarantors
   //         if ($request->is_member) {
   //             foreach ($request->member_id as $member_id) {
   //                 Guarantor::create([
   //                     'loan_id' => $loan->id,
   //                     'member_id' => $member_id,
   //                 ]);
   //             }
   //         } else {
   //             foreach ($request->non_member_names as $index => $name) {
   //                 if (!empty($name)) {
   //                     Guarantor::create([
   //                         'loan_id' => $loan->id,
   //                         'name' => $name,
   //                         'email' => $request->non_member_emails[$index] ?? null,
   //                         'telephone' => $request->non_member_telephones[$index] ?? null,
   //                         'occupation' => $request->non_member_occupations[$index] ?? null,
   //                         'address' => $request->non_member_addresses[$index] ?? null,
   //                     ]);
   //                 }
   //             }
   //         }

   //         // Save collaterals
   //         foreach ($request->collateral_item as $index => $item) {
   //             if (!empty($item)) {
   //                 $collateral = Collateral::create([
   //                     'loan_id' => $loan->id,
   //                     'collateral_item_id' => $item,
   //                     'collateral_name' => $request->collateral_name[$index] ?? null,
   //                     'estimated_value' => $request->estimated_value[$index] ?? null,
   //                     'collateral_remarks' => $request->collateral_remarks[$index] ?? null,
   //                 ]);

   //                 // Save collateral photos
   //                 if ($request->hasFile('collateral_photos')) {
   //                     foreach ($request->file('collateral_photos') as $photo) {
   //                         $path = $photo->store('collateral_photos', 'public');
   //                         $collateral->photos()->create([
   //                             'path' => $path,
   //                         ]);
   //                     }
   //                 }
   //             }
   //         }

   //         // Save documents
   //         if ($request->hasFile('photos')) {
   //             foreach ($request->file('photos') as $photo) {
   //                 $path = $photo->store('loan_documents', 'public');
   //                 Document::create([
   //                     'loan_id' => $loan->id,
   //                     'path' => $path,
   //                 ]);
   //             }
   //         }

   //         DB::commit();

   //         return redirect()->route('webmaster.loans')->with('success', 'Loan application saved successfully.');
   //     } catch (Exception $e) {
   //         DB::rollBack();
   //         return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
   //     }
   // }

   public function loanDashboard($loan_no)
   {
      $page_title = 'Loan Dashboard - ' . $loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $mbrs = Member::orderBy('fname')->get();
      $guarantorMembers = LoanGuarantor::where('is_member', 1)->pluck('member_id')->toArray();
      $members = $mbrs->whereNotIn('id', $guarantorMembers);
      $collateral_items = CollateralItem::all();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $repayments = LoanPayment::where('loan_id', $loan->id)->get();
      $documents = LoanDocument::where('loan_id', $loan->id)->get();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $roles = Role::all();
      $staffs = StaffMember::all();
      $officers = LoanOfficer::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.dashboard', compact('page_title', 'loan', 'members', 'collaterals', 'guarantors', 'repayments', 'collateral_items', 'documents', 'loancharges', 'staffs', 'officers', 'roles'));
   }

   public function loanRepaymentSchedule(Request $request)
   {
      $loan = Loan::where('loan_no', $request->loanNumber)->first();

      $numberOfInstallmentsPerYear = $request->numberOfPaymentsInAyear;
      $recoveryMode = $request->repaymentMode;
      $loanAmount = $request->principalAmount;
      $interestRate = $request->interestRate;
      $paymentPeriods = $request->numberOfInstallments;

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
      }
      // Today's date
      $disbursementDate = date_create(date($loan->disbursement_date));
      // Add one day to today's date
      $todayPlusAday = date_format(date_add($disbursementDate, date_interval_create_from_date_string('1 day')), "Y-m-d");

      //starting payment date
      $dateStartInit = date_format(date_add(date_create($todayPlusAday), date_interval_create_from_date_string($timeBeforeNextInstallment . $recoveryType)), "Y-m-d");
      //interest rate in decimal
      $interestRateInDecimal = ($interestRate / 100);
      //interest rate per period
      $interestRatePerPeriod = $interestRateInDecimal / $numberOfInstallmentsPerYear;

      //loan life span in years
      $loanDurationInYears = $paymentPeriods / $numberOfInstallmentsPerYear;
      //periodic amount to be paid in recovering loan
      $installmentAmount = ($loanAmount * $interestRatePerPeriod) / (1 - pow((1 + $interestRatePerPeriod), - ($paymentPeriods)));

      $interestInPaymentInitial = $loanAmount * ($interestRateInDecimal / $numberOfInstallmentsPerYear);

      $amountInPaymentOfPrincipalInitial = $installmentAmount - $interestInPaymentInitial;
      $endOfPeriodOutStandingBalanceInitial = $loanAmount - $amountInPaymentOfPrincipalInitial;

      $periodData['period'] = array(1);
      $interestAmountData['interestAmount'] = array($interestInPaymentInitial);
      $installmentAmountData['periodicInstallment'] = array($installmentAmount);
      $amountInPaymentOfPrincipalData['principalPaid'] = array($amountInPaymentOfPrincipalInitial);
      $endOfPeriodOutStandingBalanceData['remainingPrincipal'] = array($endOfPeriodOutStandingBalanceInitial);
      $periodicPaymentDates['dates'] = array($dateStartInit);


      for ($i = 0; $i < $paymentPeriods - 1; $i++) {
         $interestInPayment = $endOfPeriodOutStandingBalanceData['remainingPrincipal'][($i)] * ($interestRatePerPeriod);
         $amountInPaymentOfPrincipal = $installmentAmount - $interestInPayment;
         $endOfPeriodOutStandingBalance = $endOfPeriodOutStandingBalanceData['remainingPrincipal'][($i)] - $amountInPaymentOfPrincipal;
         if ($i == $paymentPeriods - 2) {
            $endOfPeriodOutStandingBalance = 0;
         }
         $dateNextStart = date_create($periodicPaymentDates['dates'][($i)]);
         $nextPaymentDate = date_format(date_add($dateNextStart, date_interval_create_from_date_string($timeBeforeNextInstallment . $recoveryType)), "Y-m-d");
         array_push($installmentAmountData['periodicInstallment'], $installmentAmount);
         array_push($interestAmountData['interestAmount'], $interestInPayment);
         array_push($amountInPaymentOfPrincipalData['principalPaid'], $amountInPaymentOfPrincipal);
         array_push($endOfPeriodOutStandingBalanceData['remainingPrincipal'], $endOfPeriodOutStandingBalance);
         array_push($periodicPaymentDates['dates'], $nextPaymentDate);
      } //array of periodic payments
      for ($j = 2; $j < $paymentPeriods + 1; $j++) {
         array_push($periodData['period'], $j);
      }
      $totalPrincipalToBePaid = array_sum($installmentAmountData['periodicInstallment']);
      $totalInterestAmount = array_sum($interestAmountData['interestAmount']);
      $principalAmount = array_sum($amountInPaymentOfPrincipalData['principalPaid']);
      $totalLoanData = array(
         'totalPrincipalToBePaid' => $totalPrincipalToBePaid,
         'totalInterestAmount' => $totalInterestAmount,
         'principalAmount' => $principalAmount,
         'numberOfPeriods' => $paymentPeriods,
      );

      //    return new JsonResponse([
      //    $periodData,
      //    $installmentAmountData,
      //    $interestAmountData,
      //    $amountInPaymentOfPrincipalData,
      //    $endOfPeriodOutStandingBalanceData,
      //    $periodicPaymentDates,
      //    $totalLoanData,
      //    ]);
      $view
         = view('webmaster.loans.repaymentschedule', compact('periodData', 'installmentAmountData', 'interestAmountData', 'amountInPaymentOfPrincipalData', 'endOfPeriodOutStandingBalanceData', 'periodicPaymentDates', 'totalLoanData'))->render();
      return response()->json(['html' => $view]);
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

      if ($validator->fails()) {
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
      $officer->access = json_encode($request->access);
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

      $page_title = 'Review Loan - ' . $loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $officers = LoanOfficer::where('loan_id', $loan->id)->get();
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      // dd($officers);
      return view('webmaster.loans.preview', compact('page_title', 'officers', 'loan', 'loancharges', 'guarantors', 'collaterals'));
   }

   public function loanReviewEdit($loan_no)
   {

      $page_title = 'Loan Preview - ' . $loan_no;
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
      LoanApplicationEvent::broadcast($loan);
      $officers = LoanOfficer::where('loan_id', $loan->id)->get()->map(function ($officer) use ($loan) {
         $staff = StaffMember::find($officer->staff_id);
         $staff->notify(new ReviewLoanNotification($loan));
      });
      // $staff->notify(new ReviewLoanNotification($loan));

      $notify[] = ['success', 'Loan Submitted for Review'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   // public function loanReviewStore(Request $request)
   // {
   //    // return response()->json($request);
   //    $validator = Validator::make($request->all(), [
   //       'notes_review'        => 'required',
   //    ], [
   //       'notes_review.required' => 'The loan notes is required.',
   //    ]);

   //    if ($validator->fails()) {
   //       return response()->json([
   //          'status' => 400,
   //          'message' => $validator->errors()
   //       ]);
   //    }


   //    $staff_id = webmaster()->id;
   //    $officer = new LoanOfficer();
   //    $loan = Loan::find($request->loan_id);
   //    $loan->status = 2;
   //    $loan->save();
   //    $officer->loan_id = $request->loan_id;
   //    $officer->staff_id = $staff_id;

   //    $officer->status = 2;
   //    $officer->comment = $request->notes;
   //    $officer->date = date('Y-m-d');
   //    $officer->save();

   //    //save activity stream
   //    ActivityStream::logActivity(webmaster()->id, 'Loan Reviewed', 2, $loan->loan_no);

   //    //approving in case user has all the rights
   //    if ($request->status) {

   //       $staff_id = webmaster()->id;
   //       $officer = new LoanOfficer();
   //       $loan = Loan::find($request->loan_id);
   //       $loan->status = $request->status;
   //       $loan->save();
   //       $officer->loan_id = $request->loan_id;
   //       $officer->staff_id = $staff_id;

   //       $officer->status = $request->status;
   //       $officer->comment = $request->notes_approval;
   //       $officer->date = date('Y-m-d');
   //       $officer->save();

   //       if ($request->status == 3) {
   //          $loanStatus = "Loan Approved";
   //       } else {
   //          $loanStatus = "Loan Rejected";
   //       }
   //       //save activity stream
   //       ActivityStream::logActivity(webmaster()->id, $loanStatus, $request->status, $loan->loan_no);
   //    }

   //    if (!$request->status) {
   //       //send email to approving authorities
   //       event(new LoanReviewedEvent($loan)); //notify approvers
   //       event(new LoanApplicantEvent($loan)); //notify applicant on loan status
   //       $notify[] = ['success', 'Loan Reviewed !'];
   //       session()->flash('notify', $notify);
   //    }else{
   //       event(new LoanApplicantEvent($loan)); //notify applicant on loan status
   //       $notify[] = ['success', 'Loan Reviewed !'];
   //       session()->flash('notify', $notify);
   //    }




   //    return response()->json([
   //       'status' => 200,
   //       'url' => route('webmaster.myloans')
   //    ]);
   // }

   public function loanReviewStore(Request $request)
   {
      // Validation
      $validator = Validator::make($request->all(), [
         'notes_review' => 'required',
      ], [
         'notes_review.required' => 'The loan notes are required.',
      ]);

      if ($validator->fails()) {
         return response()->json(['status' => 400, 'message' => $validator->errors()]);
      }

      // Check user permissions
      // if (!auth()->user()->can('approve loans') && !auth()->user()->can('disburse loans')) {
      //    return response()->json(['status' => 403, 'message' => 'Unauthorized action.'], 403);
      // }

      $staff_id = webmaster()->id;
      $loan = Loan::find($request->loan_id);
      $loan->status = 2;
      $loan->save();

      // Create LoanOfficer record for review
      $officer = new LoanOfficer();
      $officer->loan_id = $request->loan_id;
      $officer->staff_id = $staff_id;
      $officer->status = 2;
      $officer->comment = $request->notes;
      $officer->date = now()->format('Y-m-d');
      $officer->save();

      // Log review activity
      ActivityStream::logActivity($staff_id, 'Loan Reviewed', 2, $loan->loan_no);

      // Approve or Reject Loan
      if ($request->status) {
         $this->approveLoan($request, $loan);
      }

      // Send notifications
      $this->sendLoanNotifications($loan, $request->status);

      return response()->json(['status' => 200, 'url' => route('webmaster.myloans')]);
   }

   protected function approveLoan($request, $loan)
   {
      $staff_id = webmaster()->id;
      $loan->status = $request->status;
      $loan->save();

      $officer = new LoanOfficer();
      $officer->loan_id = $request->loan_id;
      $officer->staff_id = $staff_id;
      $officer->status = $request->status;
      $officer->comment = $request->notes_approval;
      $officer->date = now()->format('Y-m-d');
      $officer->save();

      $loanStatus = ($request->status == 3) ? "Loan Approved" : "Loan Rejected";
      ActivityStream::logActivity($staff_id, $loanStatus, $request->status, $loan->loan_no);
   }

   protected function sendLoanNotifications($loan, $status)
   {
      if (!$status) {
         event(new LoanReviewedEvent($loan));
      }
      event(new LoanApplicantEvent($loan));
      $notify[] = ['success', 'Loan Reviewed!'];
      session()->flash('notify', $notify);
   }


   public function loanApproval($loan_no)
   {

      $page_title = 'Approve Loan - ' . $loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();
      $reviewedOfficer = LoanOfficer::where('loan_id', $loan->id)->where('status', 2)->first();
      $reviewedOfficer = LoanOfficer::where('loan_id', $loan->id)
         ->where('status', 2)
         ->first();

      if ($reviewedOfficer && $reviewedOfficer->staffMember) {
         $officerName =  $reviewedOfficer->staffMember->title . ' ' . $reviewedOfficer->staffMember->fname . ' ' . $reviewedOfficer->staffMember->lname;
      } else {
         $officerName = '';
      }
      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.approve', compact(
         'page_title',
         'loan',
         'loancharges',
         'guarantors',
         'collaterals',
         'officerName',
         'reviewedOfficer'
      ));
   }

   public function loanApprovalStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'notes'        => 'required',
      ], [
         'notes.required' => 'The Approval  note is required.',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }


      $staff_id = webmaster()->id;
      $officer = new LoanOfficer();
      $loan = Loan::find($request->loan_id);
      $loan->status = $request->status;
      $loan->save();
      $officer->loan_id = $request->loan_id;
      $officer->staff_id = $staff_id;

      $officer->status = $request->status;
      $officer->comment = $request->notes;
      $officer->date = date('Y-m-d');
      $officer->save();

      if ($request->status == 3) {
         $loanStatus = "Loan Approved";
      } else {
         $loanStatus = "Loan Rejected";
      }
      //save activity stream
      ActivityStream::logActivity(webmaster()->id, $loanStatus, $request->status, $loan->loan_no);

      $notify[] = ['success', $loanStatus];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200,
         'url' => route('webmaster.myloans')
      ]);
   }

   public function loanDisburse($loan_no)
   {
      $user = auth()->guard('webmaster')->user();

      if (!$user->hasAnyPermission(['approve loans', 'disburse loans'])) {
         abort(403, 'Sorry! You are an unauthorized for this action.');
      }

      $page_title = 'Loan Preview - ' . $loan_no;
      $loan = Loan::where('loan_no', $loan_no)->first();

      $loancharges = LoanCharge::where('loan_id', $loan->id)->get();
      $guarantors = LoanGuarantor::where('loan_id', $loan->id)->get();
      $collaterals = LoanCollateral::where('loan_id', $loan->id)->get();
      return view('webmaster.loans.disburse', compact('page_title', 'loan', 'loancharges', 'guarantors', 'collaterals'));
   }

   public function loanDisburseStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'notes' => 'required',
         'disbursement_account' => 'required',
      ], [
         'notes.required' => 'The Approval note is required.',
         'disbursement_account.required' => 'The disbursement Account is required!',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $loan = Loan::find($request->loan_id);
      if (!$loan) {
         return response()->json(['status' => 404, 'message' => 'Loan not found'], 404);
      }

      DB::beginTransaction();
      try {
         $loan->status = $request->status;
         $loan->disbursement_date = now()->format('Y-m-d');
         $loan->disbursment_amount = $loan->principal_amount;
         $loan->save();

         $officer = new LoanOfficer();
         $officer->loan_id = $request->loan_id;
         $officer->staff_id = webmaster()->id;
         $officer->status = $request->status;
         $officer->comment = $request->notes;
         $officer->date = now()->format('Y-m-d');
         $officer->save();

         $loanStatus = ($request->status == 5) ? "Loan Disbursed" : "Loan Cancelled";
         ActivityStream::logActivity(webmaster()->id, $loanStatus, $request->status, $loan->loan_no);

         if ($request->status == 5) {
            $this->disburseLoanAmount($request->disbursement_account, $request->loan_member_account, $loan->disbursment_amount);
         }
         event(new LoanApplicantEvent($loan));

         DB::commit();

         $notify[] = ['success', $loanStatus];
         session()->flash('notify', $notify);

         return response()->json([
            'status' => 200,
            'url' => route('webmaster.myloans')
         ]);
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

   //function to transfer  money from sacco account to individual account
   public function disburseLoanAmount($saccoAccount, $memberAccount, $loanAmount)
   {
      $business_id = request()->attributes->get('business_id');
      // if (! (auth()->user()->can('superadmin') ||
      //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
      //     ! (auth()->user()->can('accounting.add_transfer'))) {
      //     abort(403, 'Unauthorized action.');
      // }

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
            'amount' => - ($this->util->num_uf($amount)),
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

   // public function loanReviewStore(Request $request)
   // {
   //    $validator = Validator::make($request->all(), [
   //      'notes'        => 'required',
   //    ], [
   //       'notes.required' => 'The loan notes is required.',
   //    ]);

   //    if($validator->fails()){
   //      return response()->json([
   //        'status' => 400,
   //        'message' => $validator->errors()
   //      ]);

   //    }


   //    $staff_id = webmaster()->id;

   //    $officer = LoanOfficer::where('loan_id', $request->loan_id)->where('staff_id', $staff_id)->first();
   //    if(!$officer){
   //       return response()->json([
   //          'status' => 400,
   //          'message' => ["notes" => ["You are not assigned to this loan"] ]
   //        ]);
   //    }

   //    $loan = Loan::find($request->loan_id);
   //    $existing_officers = explode(',', ltrim($loan->authorize_id, ','));
   //    if (!in_array($staff_id, $existing_officers)) {
   //       $existing_officers[] = $staff_id;
   //    }
   //    $loan->authorize_id = implode(',', $existing_officers);


   //    $existing_staffs = explode(',', $loan->officer_id);
   //    $index = array_search($staff_id, $existing_staffs);
   //    if ($index !== false) {
   //       unset($existing_staffs[$index]);
   //    }
   //    $existing_staffs = array_values($existing_staffs);
   //    $loan->officer_id = implode(',', $existing_staffs);
   //    $loan->status = $request->status;
   //    $loan->save();




   //    $officer->comment = $request->notes;
   //    $officer->date = date('Y-m-d');
   //    $officer->save();

   //    // Trigger the LoanReviewedEvent and notify staff
   //    event(new \App\Events\LoanReviewedEvent($loan));


   //    $notify[] = ['success', 'Loan Review updated successfully'];
   //    session()->flash('notify', $notify);

   //    return response()->json([
   //     'status' => 200,
   //      'url' => route('webmaster.myloans')
   //    ]);
   // }

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
      $title = 'Loan - #' . $loan_no;
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

      // dd($data);

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
      $officers = LoanOfficer::where('loan_id', $loan->id)->get();
      $data = [
         'title' => $title,
         'loan' => $loan,
         'loancharges' => $loancharges,
         'guarantors' => $guarantors,
         'collaterals' => $collaterals,
         'officers' => $officers,
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

      if ($validator->fails()) {
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
               'message' => ['collateral_photo' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions)],
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

      if ($validator->fails()) {
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
               'message' => ['photo' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions)],
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

   public function collateralDownload($id)
   {
      // Retrieve the collaterals for the given loan ID
      $collateralAttachments = LoanCollateral::where('loan_id', $id)->get();

      // Load the view and pass the collaterals data
      $pdf = pdf::loadView('webmaster.loans.collateral_attachments_pdf', compact('collateralAttachments'));
      // Force download of the PDF file
      return $pdf->download('collateral_attachments_loan_' . $id . '.pdf');
   }

   public function loansReport(Request $request)
   {
      $page_title = 'Loans Report';

      if ($request->ajax()) {
         $query = Loan::with('member')
            ->select('loans.*')
            ->join('members', 'loans.member_id', '=', 'members.id')
            ->selectRaw("CONCAT(members.fname, ' ', members.lname) as member_name");

         // Apply date range filter if start_date and end_date are provided
         if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('loans.created_at', [$request->start_date, $request->end_date]);
         }

         // Apply status filter if status is provided
         if ($request->has('status') && !empty($request->status)) {
            $query->where('loans.status', $request->status);
         }

         return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('member_name', function ($row) {

               return ucwords(strtolower($row->member_name));
            })

            ->addColumn('principal_amount', function ($row) {
               return generateComaSeparatedValue($row->principal_amount);
            })

            ->addColumn('repayment_amount', function ($row) {
               return generateComaSeparatedValue($row->repayment_amount);
            })
            // Format repaid_amount using the helper function
            ->addColumn('repaid_amount', function ($row) {
               return generateComaSeparatedValue($row->repaid_amount);
            })
            // Format created_at to a more human-readable form
            ->addColumn('created_at', function ($row) {
               return Carbon::parse($row->created_at)->format('F j, Y, g:i a'); // e.g., August 24, 2024, 7:25 pm
            })
            // Format disbursement_date in human-readable form if it's available, or display "Not Yet"
            ->addColumn('disbursement_date', function ($row) {
               return $row->disbursement_date
                  ? Carbon::parse($row->disbursement_date)->format('F j, Y') // Format as e.g., August 26, 2024
                  : 'Not Yet Disbursed';
            })
            ->addColumn('status', function ($row) {
               // Apply badge based on status value
               switch ($row->status) {
                  case 0:
                     return '<span class="badge badge-warning">Pending</span>';
                  case 1:
                     return '<span class="badge badge-dark">Under Review</span>';
                  case 2:
                     return '<span class="badge badge-info">Reviewed</span>';
                  case 3:
                     return '<span class="badge badge-success">Approved</span>';
                  case 4:
                     return '<span class="badge badge-danger">Rejected</span>';
                  case 5:
                     return '<span class="badge badge-primary">Disbursed</span>';
                  case 6:
                     return '<span class="badge badge-secondary">Canceled</span>';
                  default:
                     return '<span class="badge badge-dark">Unknown</span>';
               }
            })
            ->rawColumns(['status']) // Ensure the status column is interpreted as raw HTML
            ->make(true);
      }

      return view('webmaster.report.loans_report', compact('page_title'));
   }
}
