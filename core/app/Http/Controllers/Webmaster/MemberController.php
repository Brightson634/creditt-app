<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Member;
use App\Models\StaffMember;
use App\Models\Branch;
use App\Models\MemberEmail;
use App\Models\MemberContact;
use App\Models\Loan;
use App\Models\Saving;
use App\Models\Investment;
use App\Models\Statement;
use App\Models\MemberAccount;
use App\Models\GroupMember;
use App\Models\MemberDocument;
use App\Models\LoanPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function __construct()
   { 
     $this->middleware('auth:webmaster');
   }

   public function members()
   {
      $page_title = 'Registered Members';
      $members = Member::all();
      return view('webmaster.members.index', compact('page_title', 'members'));
   }

   public function memberCreate()
   {
      $page_title = 'Register Member';
      $member_no = generateMemberNumber();
      $branches = Branch::all();
      $staffs = StaffMember::all();
      return view('webmaster.members.create', compact('page_title', 'member_no', 'branches', 'staffs'));
   }

   public function memberStore(Request $request)
   {
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

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

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
      $member->telephone      = $request->telephone;
      $member->email          = strtolower($request->email);
      $member->subscriptionplan_id = $request->subscriptionplan_id;
      $member->save();

      $contact = new MemberContact();
      $contact->member_id = $member->id;
      $contact->telephone = $request->telephone;
      $contact->save();

      $memberemail = new MemberEmail();
      $memberemail->member_id = $member->id;
      $memberemail->email = strtolower($request->email);
      $memberemail->save();
      
      $notify[] = ['success', 'Member Registered Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.members')
      ]);

   }

   public function memberEdit($member_no)
   {
      $member = Member::where('member_no', $member_no)->first();
      $page_title = 'Edit Member - ' .$member_no;
      return view('webmaster.members.edit', compact('page_title', 'member'));
   }

   public function memberUpdate(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'email'       => 'required|email|unique:members',
        'telephone'   => 'required',
        'address'     => 'required'
      ], [
        'name.required'         => 'The Member names are required.',
        'email.required'        => 'The Member email is required.',
        'email.unique'          => 'The email address is already registered',
        'telephone.required'    => 'The Telephone numbers are required',
        'address.required'      => 'The Member address is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

        $member_id = $request->id;

        $member = Member::find($member_id);
        $member->name = strtoupper($request->name);
        $member->email = strtolower($request->email);
        $member->telephone = $request->telephone;
        $member->address = $request->address;
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
      $member = Member::where('member_no', $member_no)->first();
      $page_title = 'Member Dashboard: ' .$member_no;
      $savings = Saving::where('member_id', $member->id)->get();
      $accounts = MemberAccount::where('member_id', $member->id)->get();
      $statements = Statement::where('member_id', $member->id)->get();
      $loans = Loan::where('member_id', $member->id)->get();
      $contacts = MemberContact::where('member_id', $member->id)->get();
      $emails = MemberEmail::where('member_id', $member->id)->get();
      $groupmembers = GroupMember::where('member_id', $member->id)->get();
      $documents = MemberDocument::where('member_id', $member->id)->get();
      $repayments = LoanPayment::where('member_id', $member->id)->orderBy('id','DESC')->get();

      $savingdata = Saving::selectRaw('SUM(deposit_amount) as deposit_amount, COUNT(id) as total_savings')->where('member_id', $member->id)->first();

      $accountdata = MemberAccount::selectRaw('SUM(opening_balance) as opening_balance, SUM(current_balance) as current_balance, SUM(available_balance) as available_balance,  COUNT(id) as total_accounts')->where('member_id', $member->id)->first();

      $loandata = Loan::selectRaw('SUM(principal_amount) as principal_amount, SUM(interest_amount) as interest_amount, SUM(repayment_amount) as loan_amount, SUM(repaid_amount) as repaid_amount, SUM(balance_amount) as balance_amount, SUM(fees_total) as fees_total, SUM(penalty_amount) as penalty_amount')->where('member_id', $member->id)->first();

      $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->where('investor_id', $member->id)->first();
      //
      // dd($investmentdata,$savingdata);
      return view('webmaster.members.dashboard', compact('page_title', 'member', 'savings', 'accounts','statements', 'loans', 'contacts', 'emails', 'groupmembers', 'documents', 'loandata', 'investmentdata', 'savingdata', 'accountdata', 'repayments'));
   }

   public function memberPhotoUpdate(Request $request) 
   {
      $member = Member::where('id', $request->id)->first();
      if ($request->hasFile('pphoto')) {
         $temp_name = $request->file('pphoto');
         $pphoto = slugCreate($member->fname) . '_photo_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/members', $pphoto);
         if ($member->pphoto) {
            @unlink('assets/uploads/members/'.$member->pphoto);
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

      if($validator->fails()){
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

      if($validator->fails()){
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

      if($validator->fails()){
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
                    'message' => ['gphoto' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
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

   public function memberDocumentStore(Request $request) {

      $validator = Validator::make($request->all(), [
        'file_name' => 'required',
        'file' => 'required|file|max:20240',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors(),
        ]);
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
               'message' => ['file' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
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

      return response()->json([
         'status' => 200
      ]);
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

      return response()->json([
        'status' => 200
      ]);
   }

   public function memberIndividualUpdate(Request $request)
   {
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

      if($validator->fails()){
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
      $data->save();

      $notify[] = ['success', 'Member Information Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

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

      if($validator->fails()){
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

      if($validator->fails()){
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

}
