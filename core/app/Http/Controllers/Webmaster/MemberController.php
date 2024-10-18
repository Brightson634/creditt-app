<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Loan;
use App\Models\Branch;
use App\Models\Member;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Statement;
use App\Models\Investment;
use App\Models\AccountType;
use App\Models\GroupMember;
use App\Models\LoanPayment;
use App\Models\MemberEmail;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use App\Models\MemberAccount;
use App\Models\MemberContact;
use App\Models\MemberDocument;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\SendCreatedMemberEmail;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:webmaster');
   }

   public function members(Request $request)
   {
      $response = PermissionsService::check("view_members");
      if ($response) {
         return $response;
      }
      $page_title = 'Registered Members';

      $query = Member::query();

      if ($request->has('search')) {
         $search = $request->input('search');
         $query->where('fname', 'like', '%' . $search . '%')
            ->orWhere('lname', 'like', '%' . $search . '%');
      }

      $members = $query->get();

      if ($request->ajax()) {
         return view('webmaster.members.members_list', compact('members'))->render();
      }

      $members = Member::all();
      //info for member create
      $member_no = generateMemberNumber();
      $branches = Branch::all();
      $staffs = StaffMember::all();
      $accounttypes = AccountType::all();
      $account_no = generateAccountNumber();
      $accounts = MemberAccount::all();
      $fees = Fee::all();

      $activeTab = 'tab2';

      return view('webmaster.members.index', compact(
         'page_title',
         'members',
         'member_no',
         'staffs',
         'branches',
         'activeTab',
         'accounttypes',
         'accounts',
         'account_no',
         'fees'
      ));
   }

   public function memberCreate()
   {
      PermissionsService::check("add_members");
      $page_title = 'Register Members';
      $member_no = generateMemberNumber();
      $branches = Branch::all();
      $account_no = generateAccountNumber();
      $staffs = StaffMember::all();
      $accounttypes = AccountType::all();
      $accounts = MemberAccount::all();
      $fees = Fee::all();
      //info for registered members
      $members = Member::all();
      $activeTab = 'tab1';
      // dd('hi');
      return view('webmaster.members.create', compact(
         'page_title',
         'member_no',
         'branches',
         'staffs',
         'members',
         'activeTab',
         'accounttypes',
         'accounts',
         'account_no',
         'fees'
      ));
   }

   public function generateMemberId(Request $request)
   {
      $setting = Setting::find(1);
      $sysMemberPrefix = $setting->member_prefix;
      $dob = str_replace('-', '', $request->dob);
      $gender = $request->gender;
      $memberId = generateMemberUniqueID($sysMemberPrefix, $gender, $dob);
      return response()->json(['member_id' => $memberId]);
   }

   public function memberStore(Request $request)
   {
      // Validation rules and messages
      $rules = [
         'member_type'            => 'required',
         'telephone'              => 'required|unique:member_contacts',
         'email'                  => 'required|email|unique:member_emails',
         'subscriptionplan_id'    => 'required',
      ];

      $messages = [
         'member_type.required'           => 'please select the member type',
         'telephone.required'             => 'The telephone is required',
         'email.required'                 => 'The Email is required',
         'subscriptionplan_id.required'   => 'The fee rate type is required',
      ];

      if ($request->member_type == 'individual') {
         $rules += [
            'title'           => 'required',
            'fname'           => 'required',
            'lname'           => 'required',
            'gender'          => 'required',
            'marital_status'  => 'required',
            'dob'             => 'required',
         ];

         $messages += [
            'title.required'              => 'The title is required',
            'fname.required'              => 'The first name is required',
            'lname.required'              => 'The last name is required',
            'gender.required'             => 'The gender is required',
            'marital_status.required'     => 'The marital status is required',
            'dob.required'                => 'The date of birth is required',
         ];
      }

      if ($request->member_type == 'group') {
         $rules += [
            'group_name'      => 'required',
            'description'     => 'required',
         ];

         $messages += [
            'group_name.required'         => 'The group name is required',
            'description.required'        => 'The group description is required',
         ];
      }

      // Validator
      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      // Transaction and error handling
      try {
         DB::beginTransaction();

         // Create Member
         $member = new Member();
         $member->member_no = $request->member_no;
         $member->member_type = $request->member_type;

         if ($request->member_type == 'individual') {
            $member->title = $request->title;
            $member->name = strtoupper($request->fname) . strtoupper($request->lname) . strtoupper($request->oname);
            $member->fname = strtoupper($request->fname);
            $member->lname = strtoupper($request->lname);
            $member->oname = strtoupper($request->oname);
            $member->gender = $request->gender;
            $member->marital_status = $request->marital_status;
            $member->dob = $request->dob;
            $member->disability = $request->disability;
         }

         if ($request->member_type == 'group') {
            $member->name = strtoupper($request->group_name);
            $member->fname = strtoupper($request->group_name);
            $member->description = strtoupper($request->description);
         }

         $member->password = Hash::make($request->password);
         $member->telephone = $request->telephone;
         $member->email = strtolower($request->email);
         $member->subscriptionplan_id = $request->subscriptionplan_id;
         $member->save();

         // Create Member Contact
         $contact = new MemberContact();
         $contact->member_id = $member->id;
         $contact->telephone = $request->telephone;
         $contact->save();

         // Create Member Email
         $memberemail = new MemberEmail();
         $memberemail->member_id = $member->id;
         $memberemail->email = strtolower($request->email);
         $memberemail->save();

         // Send email
         $data = [
            'saccoName' => getSystemInfo()->company_name,
            'email' => $member->email,
            'memberID' => $member->member_no,
            'password' => '12345678', // You should generate a secure password here
            'loginUrl' => route('member.login'),
         ];

         $this->sendEmailToMember($data);

         DB::commit(); // Commit the transaction if everything is successful

         // Notify the user
         $notify[] = ['success', 'Member Registered Successfully!'];
         session()->flash('notify', $notify);

         return response()->json([
            'status' => 200,
            'url' => route('webmaster.members')
         ]);
      } catch (\Exception $e) {
         DB::rollBack(); // Rollback the transaction if there's an error

         // Log the error for debugging
         Log::error('Error creating member: ' . $e->getMessage());

         return response()->json([
            'status' => 500,
            'message' => 'An error occurred while creating the member. Please try again later.'
         ]);
      }
   }

   /**
    * Sends created member email with credentials to login into 
    *member dashboard
    * @param array $mailData
    * @return void
    */
   public function sendEmailToMember(array $mailData)
   {

      Mail::to($mailData['email'])->send(new SendCreatedMemberEmail($mailData));
   }

   public function memberEdit($member_no)
   {
      PermissionsService::check("edit_members", "Unauthorized action!");
      $member = Member::where('member_no', $member_no)->first();
      $page_title = 'Edit Member - ' . $member_no;
      $branches = Branch::all();
      return view('webmaster.members.edit', compact('page_title', 'member', 'branches'));
   }

   public function memberUpdate(Request $request)
   {
      // return response()->json($request);
      $validator = Validator::make($request->all(), [
         'email'     => [
            'required',
            'email',
            Rule::unique('members')->ignore($request->id),
         ],
         'telephone' => 'required',
      ], [
         'name.required'         => 'The Member names are required.',
         'email.required'        => 'The Member email is required.',
         'email.unique'          => 'The email address is already registered',
         'telephone.required'    => 'The Telephone numbers are required',
         'address.required'      => 'The Member address is required'
      ]);


      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $member_id = $request->id;

      $member = Member::find($member_id);
      $member->member_no = $request->member_no;
      $member->member_type = $request->member_type;
      if ($request->member_type == 'individual') {
         $member->title = $request->title;
         $member->name = strtoupper($request->fname) . strtoupper($request->lname) . strtoupper($request->oname);
         $member->fname = strtoupper($request->fname);
         $member->lname = strtoupper($request->lname);
         $member->oname = strtoupper($request->oname);
         $member->gender = $request->gender;
         $member->marital_status = $request->marital_status;
         $member->dob = $request->dob;
         $member->disability = $request->disability;
      }
      if ($request->member_type == 'group') {
         $member->name = strtoupper($request->group_name);
         $member->fname = strtoupper($request->group_name);
         $member->description = strtoupper($request->description);
      }
      $member->password = Hash::make($request->password);
      $member->telephone      = $request->telephone;
      $member->email          = strtolower($request->email);
      $member->subscriptionplan_id = $request->subscriptionplan_id;
      $member->status = 1;
      $member->save();

      $notify[] = ['success', 'Member Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200,
         'url' => route('webmaster.members')
      ]);
   }

   public function memberDashboard($member_no)
   {
      $response = PermissionsService::check('view_members_dashboard');
      if ($response) {
         return $response;
      }
      $member = Member::where('member_no', $member_no)->first();
      $page_title = 'Member Dashboard: ' . $member_no;
      $savings = Saving::where('member_id', $member->id)->get();
      $accounts = MemberAccount::where('member_id', $member->id)->get();
      $statements = Statement::where('member_id', $member->id)->get();
      $loans = Loan::where('member_id', $member->id)->get();
      $contacts = MemberContact::where('member_id', $member->id)->get();
      $emails = MemberEmail::where('member_id', $member->id)->get();
      $groupmembers = GroupMember::where('member_id', $member->id)->get();
      $documents = MemberDocument::where('member_id', $member->id)->get();
      $repayments = LoanPayment::where('member_id', $member->id)->orderBy('id', 'DESC')->get();

      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->where('member_id', $member->id)->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance, 
      COUNT(id) as total_accounts, accounttype_id, account_no as accNumber')->where('member_id', $member->id)->first();

      $accType = (AccountType::where('id', $accountdata->accounttype_id)->first());
      if ($accType != null) {
         $accountdata->accType = $accType->name;
      }

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount) as balance_amount, 
      SUM(fees_total) as fees_total, SUM(penalty_amount) as penalty_amount')->where('member_id', $member->id)->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->where('investor_id', $member->id)->first();
      //
      // dd($investmentdata,$savingdata);
      return view('webmaster.members.dashboard', compact('page_title', 'member', 'savings', 'accounts', 'statements', 'loans', 'contacts', 'emails', 'groupmembers', 'documents', 'loandata', 'investmentdata', 'savingdata', 'accountdata', 'repayments'));
   }

   public function memberPhotoUpdate(Request $request)
   {
      $member = Member::where('id', $request->id)->first();
      if ($request->hasFile('pphoto2')) {
         $temp_name = $request->file('pphoto2');
         $pphoto = slugCreate($member->fname) . '_photo_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/members', $pphoto);
         if ($member->pphoto) {
            @unlink('assets/uploads/members/' . $member->pphoto);
         }
      }

      Member::where('id', $request->id)->update([
         'photo' => $pphoto
      ]);

      $notify[] = ['success', 'Member Photo updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberContactStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'telephone'            => 'required|unique:member_contacts',
      ], [
         'telephone.required'   => 'The telephone is required',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $contact = new MemberContact();
      $contact->member_id = $request->member_id;
      $contact->telephone = $request->telephone;
      $contact->save();

      $notify[] = ['success', 'Contact added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberContactDelete(Request $request)
   {
      $data = MemberContact::find($request->id);
      $data->delete();

      $notify[] = ['success', 'Contact deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberEmailStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'email'            => 'required|email|unique:member_emails',
      ], [
         'email.required'   => 'The email is required',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $memberemail = new MemberEmail();
      $memberemail->member_id = $request->member_id;
      $memberemail->email = $request->email;
      $memberemail->save();

      $notify[] = ['success', 'Email added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberEmailDelete(Request $request)
   {
      $data = MemberEmail::find($request->id);
      $data->delete();

      $notify[] = ['success', 'Email deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }


   public function groupmemberStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'gname'         => 'required',
         'gdesignation'  => 'required',
         'gtelephone'    => 'required',
         'gemail'        => 'required',
         'gaddress'      => 'required',
         'gphoto'        => 'required|image|max:2048|mimes:jpeg,jpg,png,JPG,PNG,JPEG',
      ], [
         'gname.required'              => 'The names is required',
         'gdesignation.required'       => 'The designation is required',
         'gtelephone.required'         => 'The telephone is required',
         'gemail.required'             => 'The email is required',
         'gaddress.required'           => 'The address is required',
         'gphoto.required'             => 'The  photo is required',
         'gphoto.image'                => 'The uploaded file must be an image.',
         'gphoto.max'                  => 'The uploaded file may not be larger than 2MB.',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      if ($request->hasFile('gphoto')) {
         $temp_name = $request->file('gphoto');
         $gphoto = $request->member_no . 'groupmember_photo' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/members', $gphoto);
         $ext = pathinfo($gphoto, PATHINFO_EXTENSION);
         $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
         if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
               'status' => 400,
               'message' => ['gphoto' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions)],
            ]);
         }
      }

      $groupmember = new GroupMember();
      $groupmember->member_id = $request->member_id;
      $groupmember->name = $request->gname;
      $groupmember->designation = $request->gdesignation;
      $groupmember->email = $request->gemail;
      $groupmember->telephone = $request->gtelephone;
      $groupmember->address = $request->gaddress;
      $groupmember->photo = $gphoto;
      $groupmember->save();

      $notify[] = ['success', 'Group member added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function groupmemberDelete(Request $request)
   {
      $groupmember = GroupMember::find($request->id);
      if ($groupmember) {
         @unlink('assets/uploads/members/' . $groupmember->photo);
         $groupmember->delete();
      }
      $notify[] = ['success', 'Group member deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberDocumentStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'file_name' => 'required',
         'file' => 'required|file|max:20240',
      ]);

      if ($validator->fails()) {
         if ($request->expectsJson()) {
            // For AJAX requests, return a JSON response
            return response()->json([
               'status' => 400,
               'message' => $validator->errors(),
            ]);
         } else {
            $errors = $validator->errors()->all();
            $notify = [];

            foreach ($errors as $error) {
               $notify[] = ['error', $error];
            }

            session()->flash('notify', $notify);

            return redirect()->back()->withInput();
         }
      }


      if ($request->hasFile('file')) {
         $temp_name = $request->file('file');
         $uploaded_file = $request->member_no . 'document_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/members', $uploaded_file);
         $ext = pathinfo($uploaded_file, PATHINFO_EXTENSION);
         $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];

         if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
               'status' => 400,
               'message' => ['file' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions)],
            ]);
         }
      }

      if (in_array($ext, ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'])) {
         $file_type = 'Image File';
      } else if (in_array($ext, ['doc', 'docx'])) {
         $file_type = 'Word Document';
      } else if ($ext == 'ppt') {
         $file_type = 'Powerpoint Document';
      } else if (in_array($ext, ['pptx', 'xls', 'xlsx'])) {
         $file_type = 'Excel Document';
      } else if ($ext == 'pdf') {
         $file_type = 'PDF Document';
      } else {
         $file_type = 'Unknown File Type';
      }

      $file = new MemberDocument();
      $file->member_id = $request->member_id;
      $file->file_name = $request->file_name;
      $file->file = $uploaded_file;
      $file->file_type = $file_type;
      $file->save();

      $notify[] = ['success', 'Document Uploaded successfully!'];
      session()->flash('notify', $notify);

      if ($request->expectsJson()) {
         // For AJAX requests, return a JSON response
         return response()->json([
            'status' => 200
         ]);
      } else {
         return redirect()->back();
      }
   }

   public function memberDocumentDelete(Request $request)
   {
      $memberdocument = MemberDocument::find($request->id);
      if ($memberdocument) {
         @unlink('assets/uploads/members/' . $memberdocument->file);
         $memberdocument->delete();
      }
      $notify[] = ['success', 'Member Document deleted successfully!'];
      session()->flash('notify', $notify);

      if ($request->expectsJson()) {
         // For AJAX requests, return a JSON response
         return response()->json([
            'status' => 200
         ]);
      } else {
         return redirect()->back();
      }
   }

   public function memberIndividualUpdate(Request $request)
   {
      if ($request->info_type != 'nok') {
         $validator = Validator::make($request->all(), [
            'title'               => 'required',
            'fname'               => 'required',
            'lname'               => 'required',
            'gender'              => 'required',
            'marital_status'      => 'required',
            'dob'                 => 'required'
         ], [
            'title.required'                     => 'The title is required',
            'fname.required'                     => 'The first name is required',
            'lname.required'                     => 'The last name is required',
            'gender.required'                    => 'The gender is required',
            'marital_status.required'            => 'The marital status is required',
            'dob.required'                       => 'The date of birth is required',
         ]);

         if ($validator->fails()) {
            return response()->json([
               'status' => 400,
               'message' => $validator->errors()
            ]);
         }

         $member_id = $request->id;

         $data = Member::find($member_id);
         $data->title = $request->title;
         $data->fname = strtoupper($request->fname);
         $data->lname = strtoupper($request->lname);
         $data->oname = strtoupper($request->oname);
         $data->gender = $request->gender;
         $data->marital_status = $request->marital_status;
         $data->disability = $request->disability;
         $data->dob = $request->dob;
         $data->nin = $request->nin;
         $data->save();

         $notify[] = ['success', 'Member Information Updated Successfully!'];
         session()->flash('notify', $notify);

         return response()->json([
            'status' => 200,
            'message' => true
         ]);
      } else {
         $member = Member::find($request->member_id);
         $member->next_of_kin_name = $request->next_of_kin_name;
         $member->next_of_kin_contact = $request->next_of_kin_contact;
         $member->next_of_kin_relationship = $request->next_of_kin_relationship;
         $member->emergency_contact_name = $request->emergency_contact_name;
         $member->emergency_contact_phone = $request->emergency_contact_phone;
         $member->occupation = $request->occupation;
         $member->employer = $request->employer;
         $member->work_address = $request->work_address;
         $member->current_address = $request->current_address;
         try {
            $member->save();
            return response()->json([
               'status' => 200,
               'message' => true
            ]);
         } catch (\Exception $e) {
            return response()->json([
               'status' => 422,
               'message' => 'Something went wrong' . $e->getMessage(),
            ]);
         }
      }
   }

   public function memberBiodataUpdate(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'nin'        => 'required',
         'no_of_children'       => 'required|numeric',
         'no_of_dependant'   => 'required|numeric',
         'crbcard_no'     => 'required',
         'occupation'     => 'required'
      ], [
         'nin.required'                 => 'The National ID are required.',
         'no_of_children.required'      => 'The number of children is required.',
         'no_of_dependant.required'    => 'The number of dependants is required',
         'crbcard_no.required'          => 'The crbcard number are required',
         'occupation.required'          => 'The occupation is required'

      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $member_id = $request->id;

      $biodata = Member::find($member_id);
      $biodata->nin = strtoupper($request->nin);
      $biodata->no_of_children = $request->no_of_children;
      $biodata->no_of_dependant = $request->no_of_dependant;
      $biodata->crbcard_no = $request->crbcard_no;
      $biodata->occupation = $request->occupation;
      $biodata->save();

      $notify[] = ['success', 'Member Biodata Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function memberGroupUpdate(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'group_name'  => 'required',
         'description' => 'required',
      ], [
         'group_name.required'     => 'The group name is required',
         'description.required'    => 'The group description is required'
      ]);

      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $member_id = $request->id;

      $data = Member::find($member_id);
      $data->fname = strtoupper($request->group_name);
      $data->description = strtoupper($request->description);
      $data->save();

      $notify[] = ['success', 'Group Information Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
         'status' => 200
      ]);
   }

   public function membersReport(Request $request)
   {
      $response = PermissionsService::check('view_member_reports');
      if ($response) {
         return $response;
      }
      $page_title = 'Members Report';

      if ($request->ajax()) {
         $query = Member::select('members.*');

         //   // Apply date range filter if provided
         if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('members.created_at', [$request->start_date, $request->end_date]);
         }

         //   // Apply gender filter if provided
         if ($request->has('gender') && !empty($request->gender)) {
            $query->where('members.gender', $request->gender);
         }

         return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('member_name', function ($row) {
               return ucwords(strtolower($row->fname . ' ' . $row->lname));
            })
            ->addColumn('occupation', function ($row) {
               return $row->occupation ? ucwords(strtolower($row->occupation)) : 'N/A';
            })
            ->addColumn('current_address', function ($row) {
               return $row->occupation ? ucwords(strtolower($row->current_address)) : 'N/A';
            })

            ->addColumn('dob', function ($row) {
               return $row->dob ? Carbon::parse($row->dob)->format('F j, Y') : 'N/A';
            })
            ->addColumn('gender', function ($row) {
               return $row->gender ? $row->gender : 'N/A';
            })
            ->addColumn('created_at', function ($row) {
               return Carbon::parse($row->created_at)->format('F j, Y, g:i a');
            })
            ->rawColumns(['status'])
            ->make(true);
      }

      return view('webmaster.report.members_report', compact('page_title'));
   }

   public function memberProfile(Request $request)
   {
      if (!$request->has('accId') || empty($request->accId)) {
         return response()->json(['error' => 'Account ID is required.'], 400);
      }

      $memberAccId = memberAccountId($request->accId);

      if (!$memberAccId) {
         return response()->json(['error' => 'Invalid Account ID.'], 400);
      }

      $memberAcc = MemberAccount::find($memberAccId);

      if (!$memberAcc) {
         return response()->json(['error' => 'Member account not found.'], 404);
      }

      $memberDetails = $memberAcc->member;

      if (empty($memberDetails)) {
         return response()->json(['error' => 'Member details not found.'], 404);
      }

      $branch_id = request()->attributes->get('business_id');
      $memberDetails->accountBalance = getAccountBalance($request->accId, $branch_id);

      $view = view('webmaster.members.member_profile', compact('memberAcc', 'memberDetails'))->render();

      return response()->json(['html' => $view, 'status' => 200]);
   }

   public function memberDelete(Request $request)
   {

      if (!Auth::guard('webmaster')->user()->can('delete_members')) {
         return response()->json([
            'status' => 404,
            'message' => 'Unauthorized Action!'
         ]);
      }

      $member = Member::findOrFail($request->id);
      if ($member) {
         $member->delete();
         return response()->json([
            'status' => 200,
            'message' => 'Member Deleted'
         ]);
      }
      return response()->json([
         'status' => 404,
         'message' => 'Member not found'
      ]);
   }
}
