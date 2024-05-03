<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\StaffMember;
use App\Models\Branch;
use App\Models\BranchPosition;
use App\Models\StaffNotification;
use App\Models\StaffEmail;
use App\Models\StaffContact;
use App\Models\StaffDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffMemberController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function staffs()
   {
      $page_title = 'Staff Members';
      $staffs = StaffMember::all();
      return view('webmaster.staffs.index', compact('page_title', 'staffs'));
   }

   public function staffCreate()
   {
      $page_title = 'Add Staff Member';
      $staff_no = generateStaffNumber();
      $branches = Branch::all();
      $positions = BranchPosition::all();
      return view('webmaster.staffs.create', compact('page_title', 'staff_no', 'branches', 'positions'));
   }

   public function staffStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'title'                  => 'required',
        'fname'                  => 'required',
        'lname'                  => 'required',
        'telephone'              => 'required',
        'email'                  => 'required|email|unique:staff_members',
        'password'               => 'required',
        'branch_id'              => 'required',
        'branchposition_id'      => 'required',
      ], [
        'title.required'                  => 'The title is required',
        'fname.required'                  => 'The first name is required',
        'lname.required'                  => 'The last name is required',
        'telephone.required'              => 'The telephone is required',
        'email.required'                  => 'The email is required.',
        'email.unique'                    => 'The email is already registered',
        'password.required'               => 'The password is required.',
        'branch_id.required'              => 'The branch is required',
        'branchposition_id.required'      => 'The position is required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $staff = new StaffMember();
      $staff->staff_no = $request->staff_no;
      $staff->title = $request->title;
      $staff->fname = strtoupper($request->fname);
      $staff->lname = strtoupper($request->lname);
      $staff->telephone = $request->telephone;
      $staff->email = strtolower($request->email);
      $staff->password = Hash::make($request->password);
      $staff->branch_id = $request->branch_id;
      $staff->branchposition_id = $request->branchposition_id;
      $staff->save();

      $contact = new StaffContact();
      $contact->staff_id = $staff->id;
      $contact->telephone = $request->telephone;
      $contact->save();

      $staffemail = new StaffEmail();
      $staffemail->staff_id = $staff->id;
      $staffemail->email = strtolower($request->email);
      $staffemail->save();

      $notify[] = ['success', 'Staff Member added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.staffs')
      ]);
   }


   public function staffDashboard($staff_no)
   {
      $staff = StaffMember::where('staff_no', $staff_no)->first();
      $page_title = 'Staff Dashboard: ' .$staff_no;
      $contacts = StaffContact::where('staff_id', $staff->id)->get();
      $emails = StaffEmail::where('staff_id', $staff->id)->get();
      $documents = StaffDocument::where('staff_id', $staff->id)->get();
      $branches = Branch::all();
      $positions = BranchPosition::all();
      return view('webmaster.staffs.dashboard', compact('page_title', 'staff', 'contacts', 'emails', 'documents', 'branches', 'positions'));
   }

   


}
