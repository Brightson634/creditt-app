<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Investor;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InvestorController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function investors()
   {
      $page_title = 'Investors';
      $investors = Investor::all();
      return view('webmaster.investors.index', compact('page_title', 'investors'));
   }

   public function investorCreate()
   {
      $page_title = 'Add Investor';
      return view('webmaster.investors.create', compact('page_title'));
   }

   public function investorStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'              => 'required',
        'designation'       => 'required',
        'address'           => 'required',
        'telephone'         => 'required',
        'email'             => 'required|email|unique:investors',
        'photo'             => 'required|image|max:2048|mimes:jpeg,jpg,png,JPG,PNG,JPEG',
      ], [
        'name.required'             => 'The name is required',
        'designation.required'      => 'The designation is required',
        'email.required'            => 'The email is required',
        'telephone.required'        => 'The telephone is required',
        'address.required'          => 'The address is required.',
        'photo.required'            => 'The photo is required',
        'photo.image'               => 'The uploaded file must be an image.',
        'photo.max'                 => 'The uploaded file may not be larger than 2MB.',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      if ($request->hasFile('photo')) {
         $temp_name = $request->file('photo');
         $photo = $request->name . 'investor_photo' . uniqid() . time() . '.' . $temp_name->getClientOriginalExtension();
         $temp_name->move('assets/uploads/investors', $photo);
         $ext = pathinfo($photo, PATHINFO_EXTENSION);
         $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'PNG', 'JPEG'];
         if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
               'status' => 400,
               'message' => ['photo' => 'Only these files are allowed: ' . implode(', ', $allowedExtensions) ],
            ]);
         }
      }

      $investor = new Investor();
      $investor->name = strtoupper($request->name);
      $investor->designation = $request->designation;
      $investor->email = strtolower($request->email);
      $investor->telephone = $request->telephone;
      $investor->address = $request->address;
      $investor->photo = $photo;
      $investor->save();

      $notify[] = ['success', 'Investor added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.investors')
      ]);
   }

   public function investorDashboard($id)
   {
      $investor = Investor::where('id', $id)->first();
      $page_title = 'Investor Dashboard: ' .$investor->name;
      $investments = Investment::where('id', $id)->where('investor_type', 'nonmember')->get();
       $investmentdata = Investment::selectRaw('SUM(investment_amount) as investment_amount, SUM(interest_amount) as interest_amount, SUM(roi_amount) as roi_amount, COUNT(id) as total_investments')->where('investor_id', $id)->first();
      return view('webmaster.investors.dashboard', compact('page_title', 'investor', 'investments', 'investmentdata'));
   }

   


}
