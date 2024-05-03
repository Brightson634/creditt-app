<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function branches()
   {
      $page_title = 'Branches';
      $branches = Branch::all();
      return view('webmaster.branches.index', compact('page_title', 'branches'));
   }

   public function branchCreate()
   {
      $page_title = 'Add Branch';
      $branch_no = generateBranchNumber();
      return view('webmaster.branches.create', compact('page_title', 'branch_no'));
   }

   public function branchStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'email'       => 'required|email|unique:branches',
        'telephone'   => 'required',
        'physical_address'     => 'required',
        'postal_address'     => 'required'
      ], [
        'name.required'                => 'The name are required.',
        'email.required'               => 'The email is required.',
        'email.unique'                 => 'The email is already registered',
        'telephone.required'           => 'The telephone is required',
        'postal_address.required'      => 'The postal address is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

        $branch = new Branch();
        $branch->branch_no = $request->branch_no;
        $branch->name = strtoupper($request->name);
        $branch->email = strtolower($request->email);
        $branch->telephone = $request->telephone;
        $branch->physical_address = $request->physical_address;
        $branch->postal_address = $request->postal_address;
        $branch->is_main = $request->is_main;
        $branch->save();

      $notify[] = ['success', 'Branch added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.branches')
      ]);
   }

   


}
