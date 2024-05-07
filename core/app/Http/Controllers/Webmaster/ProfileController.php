<?php


use App\Models\StaffMember;
use App\Models\StaffNotification;
use App\Models\StaffEmail;
use App\Models\StaffContact;
use App\Models\StaffDocument;
use App\Models\Branch;
use App\Models\BranchPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Khill\Lavacharts\Lavacharts;



class ProfileController extends Controller
{ 
    public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
  
   public function profile()
   {
      $page_title = 'Staff Profile';
      $webmaster = Auth::guard('webmaster')->user();
      $contacts = StaffContact::where('staff_id', $webmaster->id)->get();
      $emails = StaffEmail::where('staff_id', $webmaster->id)->get();
      $documents = StaffDocument::where('staff_id', $webmaster->id)->get();
      $branches = Branch::all();
      $positions = BranchPosition::all();
      return view('webmaster.profile.profile', compact('page_title', 'webmaster', 'contacts', 'emails', 'documents', 'branches', 'positions'));
   }

   public function staffPhotoUpdate(Request $request) 
   {
      $staff = StaffMember::where('id', $request->id)->first();
      if ($request->hasFile('photo')) {
         $temp_name = $request->file('photo');
         $photo = webmaster()->staff_no . '_photo_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/staffs', $photo);
         if ($staff->photo) {
            @unlink('assets/uploads/staffs/'.$staff->photo);
         }
      }

      StaffMember::where('id', $request->id)->update([ 
         'photo' => $photo 
      ]);

      $notify[] = ['success', 'Photo updated successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);
   }

   public function staffSignatureUpdate(Request $request) 
   {
      $staff = StaffMember::where('id', $request->id)->first();
      if ($request->hasFile('signature')) {
         $temp_name = $request->file('signature');
         $signature = webmaster()->staff_no . '_signature_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/staffs', $signature);
         if ($staff->signature) {
            @unlink('assets/uploads/staffs/'.$staff->signature);
         }
      }

      StaffMember::where('id', $request->id)->update([ 
         'signature' => $signature 
      ]);

      $notify[] = ['success', 'Signature updated successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);
   }

   public function staffInformationUpdate(Request $request)
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

      $data = StaffMember::find(webmaster()->id);
      $data->title = $request->title;
      $data->fname = strtoupper($request->fname);
      $data->lname = strtoupper($request->lname);
      $data->oname = strtoupper($request->oname);
      $data->gender = $request->gender;
      $data->marital_status = $request->marital_status;
      $data->disability = $request->disability;
      $data->dob = $request->dob;
      $data->save();

      $notify[] = ['success', 'Information Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

   }

   public function staffBiodataUpdate(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'nin'                    => 'required',
        'no_of_children'         => 'required|numeric',
        'no_of_dependant'        => 'required|numeric',
        'crbcard_no'             => 'required',
        'branch_id'              => 'required',
        'branchposition_id'      => 'required'
      ], [
        'nin.required'                    => 'The National ID are required.',
        'no_of_children.required'         => 'The number of children is required.',
        'no_of_dependant.required'        => 'The number of dependants is required',
        'crbcard_no.required'             => 'The crbcard number are required',
        'branch_id.required'              => 'The branch is required',
        'branchposition_id.required'      => 'The designation is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $biodata = StaffMember::find(webmaster()->id);
      $biodata->nin = strtoupper($request->nin);
      $biodata->no_of_children = $request->no_of_children;
      $biodata->no_of_dependant = $request->no_of_dependant;
      $biodata->crbcard_no = $request->crbcard_no;
      $biodata->branch_id = $request->branch_id;
      $biodata->branchposition_id = $request->branchposition_id;
      $biodata->save();

      $notify[] = ['success', 'Biodata Updated Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }



   public function profileupdate(Request $request)
    {
      $webmaster_id = $request->id;
      $webmaster = StaffMember::find($webmaster_id);

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->getMessageBag()
        ]);
      }

      StaffMember::where('id', $webmaster_id)->update([ 
          'name' => $request->name,
          'username' => usernameGenerate($request->email),
          'email' => $request->email,
          'phone' => $request->phone
      ]);

      $notify = ['success', 'Profile information updated successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);
  }

  public function updatepassword(Request $request) 
  {
      $webmaster_id = $request->id;
      $webmaster = Webmaster::find($webmaster_id);
      //$webmaster = Webmaster::where('id', $webmaster_id)->first();

      $validator = Validator::make($request->all(), [
            'old_password'  => 'required|min:8',
            'new_password'  => 'required|min:8',
            'confirm_password' => 'required|min:8|same:new_password'
      ], [
            'confirm_password.same' => 'passwords do not match',
            'confirm_password.required' => 'confirm password is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->getMessageBag()
        ]);
      }

      if (!Hash::check($request->old_password, $webmaster->password)) {
        return response()->json([
          'status' => 400,
          'message' => [ 'old_password' => 'The old password is wrong' ]
        ]);
      }

      StaffMember::where('id', $webmaster_id)->update([ 
        'password' => Hash::make($request->new_password)
      ]);

      $notify = ['success', 'Password changed successfully!'];
      session()->flash('notify', $notify); 

      return response()->json([
         'status' => 200
      ]);    

  }

   public function staffDocumentStore(Request $request) {

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
         $uploaded_file = webmaster()->staff_no . 'document_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/staffs', $uploaded_file);
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

      $file = new StaffDocument();
      $file->staff_id = webmaster()->id;
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

   public function staffDocumentDelete(Request $request)
   {
      $document = StaffDocument::find($request->id);
      if ($document) {
         @unlink('assets/uploads/staffs/' . $document->file);
         $document->delete();
      }
      $notify[] = ['success', 'Document deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   public function staffEmailStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'email'            => 'required|email|unique:staff_emails',
      ], [
         'email.required'   => 'The email is required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $staffemail = new StaffEmail();
      $staffemail->staff_id = webmaster()->id;
      $staffemail->email = $request->email;
      $staffemail->save();

      $notify[] = ['success', 'Email added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   public function staffEmailDelete(Request $request)
   {
      $data = StaffEmail::find($request->id);
      $data->delete();

      $notify[] = ['success', 'Email deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   public function staffContactStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'telephone'            => 'required|unique:staff_contacts',
      ], [
         'telephone.required'   => 'The telephone is required',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $contact = new StaffContact();
      $contact->staff_id = webmaster()->id;
      $contact->telephone = $request->telephone;
      $contact->save();

      $notify[] = ['success', 'Contact added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   public function staffContactDelete(Request $request)
   {
      $data = StaffContact::find($request->id);
      $data->delete();

      $notify[] = ['success', 'Contact deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

    public function logout()
    {
        //Auth::guard('webmaster')->logout();
        $auth = Auth::guard('webmaster');
        $auth->logout();

        $notify[] = ['success', 'Logout successfully!'];
        session()->flash('notify', $notify);
        
        return redirect('/webmaster');
    }

    


}