<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Investment;
use App\Models\InvestmentPlan;
use App\Models\Member;
use App\Models\Investor;
use App\Models\InvestmentDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function investments()
   {
      $page_title = 'Investments';
      $data['memberinvestments'] = Investment::where('investor_type', 'member')->get();
      $data['nonmemberinvestments'] = Investment::where('investor_type', 'nonmember')->get();
      return view('webmaster.investments.index', compact('page_title', 'data'));
   }

   public function investmentCreate()
   {
      $page_title = 'Add Investment';
      $investment_no = generateInvestmentNumber();
      $members = Member::all();
      $plans = InvestmentPlan::all();
      $investors = Investor::all();
      return view('webmaster.investments.create', compact('page_title', 'investment_no', 'members', 'plans', 'investors'));
   }

   public function investmentStore(Request $request)
   {
      $rules = [
        'investor_type'          => 'required',
        'investment_amount'      => 'required',
        'investmentplan_id'      => 'required',
        'investment_period'      => 'required',
      ];

      $messages = [
         'investor_type.required'         => 'The investor type are required.',
         'investment_amount.required'     => 'The amount required',
         'investmentplan_id.required'     => 'The plan is required',
         'investment_period.required'     => 'The period is required'
      ];

      if ($request->investor_type == 'member') {
         $rules += [
            'member_id'        => 'required',
         ];
            
         $messages += [
            'member_id.required'    => 'The member is required'
         ];
      }

      if ($request->investor_type == 'nonmember') {
         $rules += [
            'investor_id'        => 'required',
         ];
            
         $messages += [
            'investor_id.required'    => 'The non member is required'
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $investment = new Investment();
      $investment->investment_no                = $request->investment_no;
      $investment->investor_type                = $request->investor_type;
      $investment->investor_id                  = ($request->investor_type == 'member') ? $request->member_id : $request->investor_id;
      $investment->investment_amount            = $request->investment_amount;
      $investment->investmentplan_id            = $request->investmentplan_id;
      $investment->investment_period            = $request->investment_period;
      $investment->interest_amount              = $request->interest_amount;
      $investment->roi_amount                   = $request->roi_amount;
      $investment->end_date                     = $request->end_date;
      $investment->save();

      $notify[] = ['success', 'Investment added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.investments')
      ]);
   }


   public function investmentInvestorStore(Request $request)
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
            $gphoto = $request->gname . 'investor_photo' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
            $temp_name->move('assets/uploads/investors', $gphoto);
            $ext = pathinfo($gphoto, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
            if (!in_array($ext, $allowedExtensions)) {
                return response()->json([
                    'status' => 400,
                    'message' => ['gphoto' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
                ]);
            }
      }

      $investor = new Investor();
      $investor->name = strtoupper($request->gname);
      $investor->designation = $request->gdesignation;
      $investor->email = $request->gemail;
      $investor->telephone = $request->gtelephone;
      $investor->address = $request->gaddress;
      $investor->photo = $gphoto;
      $investor->save();

      $investors = Investor::all();

      return response()->json([
         'status' => 200,
         'investors' => $investors
      ]);

   }

   public function investmentDashboard($investment_no)
   {
      $investment = Investment::where('investment_no', $investment_no)->first();
      $page_title = 'Dashboard: ' .$investment_no;
      $documents = InvestmentDocument::where('investment_id', $investment->id)->get();
      return view('webmaster.investments.dashboard', compact('page_title', 'investment', 'documents'));
   }

   public function investmentDocumentStore(Request $request) 
   {
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
         $uploaded_file = $request->investment_no . 'document_' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/investments', $uploaded_file);
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

      $file = new InvestmentDocument();
      $file->investment_id = $request->investment_id;
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

   public function investmentDocumentDelete(Request $request)
   {
      $document = InvestmentDocument::find($request->id);
      if ($document) {
         @unlink('assets/uploads/investments/' . $document->file);
         $document->delete();
      }
      $notify[] = ['success', 'Document deleted successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }

   


}

