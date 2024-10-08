<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Branch;
use App\Models\StaffEmail;
use App\Models\StaffMember;
use App\Models\StaffContact;
use Illuminate\Http\Request;
use App\Models\StaffDocument;
use App\Models\BranchPosition;
use App\Models\StaffNotification;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
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
    PermissionsService::check('view_staff');
    $page_title = 'Staff Members';
    $staffs = StaffMember::all();
    return view('webmaster.staffs.index', compact('page_title', 'staffs'));
  }

  public function staffCreate()
  {
    PermissionsService::check('add_staff');
    $page_title = 'Add Staff Member';
    $staff_no = generateStaffNumber();
    $branches = Branch::all();
    $positions = BranchPosition::all();
    $roles = Role::all();
    return view('webmaster.staffs.create', compact('page_title', 'staff_no', 'branches', 'positions', 'roles'));
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
      'role'                   => 'required',
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
      'role.required'                   => 'The role field is required.',
      'branch_id.required'              => 'The branch is required',
      'branchposition_id.required'      => 'The position is required',
    ]);

    if ($validator->fails()) {
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
    $staff->role_id = $request->role;
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
    PermissionsService::check('view_staff_dashboard');
    $staff = StaffMember::where('staff_no', $staff_no)->first();
    $page_title = 'Staff Dashboard: ' . $staff_no;
    $contacts = StaffContact::where('staff_id', $staff->id)->get();
    $emails = StaffEmail::where('staff_id', $staff->id)->get();
    $documents = StaffDocument::where('staff_id', $staff->id)->get();
    $branches = Branch::all();
    $positions = BranchPosition::all();
    return view('webmaster.staffs.dashboard', compact('page_title', 'staff', 'contacts', 'emails', 'documents', 'branches', 'positions'));
  }
  public function staffEdit($id)
  {
    if(!Auth::guard('webmaster')->user()->can('edit_staff')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    $page_title = "Staff Update";
    $branches = Branch::all();
    $positions = BranchPosition::all();
    $roles = Role::all();
    $staffMember = StaffMember::findOrFail($id);
    return view('webmaster.staffs.edit', compact('staffMember', 'roles', 'positions', 'branches', 'page_title'));
  }
  public function staffUpdate(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'title'                  => 'required',
      'fname'                  => 'required',
      'lname'                  => 'required',
      'telephone'              => 'required' . $request->staff_id,
      'email'                  => 'required' . $request->staff_id,
      'password'               => 'required',
      'role'                   => 'required',
      'branch_id'              => 'required',
      'branchposition_id'      => 'required',
    ], [
      'title.required'                  => 'The title is required',
      'fname.required'                  => 'The first name is required',
      'lname.required'                  => 'The last name is required',
      'telephone.required'              => 'The telephone is required',
      'telephone.unique'                => 'The telephone number is already registered',
      'email.required'                  => 'The email is required.',
      'email.unique'                    => 'The email is already registered',
      'password.required'               => 'The password is required.',
      'role.required'                   => 'The role field is required.',
      'branch_id.required'              => 'The branch is required',
      'branchposition_id.required'      => 'The position is required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }


    $staff = StaffMember::where('staff_no', $request->staff_no)->first();
    $staff->title = $request->title;
    $staff->fname = strtoupper($request->fname);
    $staff->lname = strtoupper($request->lname);
    $staff->telephone = $request->telephone;
    $staff->email = strtolower($request->email);
    $staff->password = Hash::make($request->password);
    $staff->branch_id = $request->branch_id;
    $staff->role_id = $request->role;
    $staff->branchposition_id = $request->branchposition_id;
    $staff->save();

    // Update or create contact
    $contact = StaffContact::updateOrCreate(
      ['staff_id' => $staff->id],
      ['telephone' => $request->telephone]
    );

    // Update or create staff email
    $staffemail = StaffEmail::updateOrCreate(
      ['staff_id' => $staff->id],
      ['email' => strtolower($request->email)]
    );



    $notify[] = ['success', 'Staff Updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.staffs')
    ]);
  }
  public function staffDestroy($id)
  {
    if(!Auth::guard('webmaster')->user()->can('delete_staff')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    // Find the staff member by ID
    $staffMember = StaffMember::findOrFail($id);

    // Delete the staff member
    $staffMember->delete();

    $notify[] = ['success', 'Staff member deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Staff member deleted successfully.');
  }
}
