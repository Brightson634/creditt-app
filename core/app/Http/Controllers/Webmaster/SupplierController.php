<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function suppliers()
   {
      $page_title = 'Supplier';
      $suppliers = Supplier::all();
      return view('webmaster.suppliers.index', compact('page_title', 'suppliers'));
   }

   public function supplierCreate()
   {
      $page_title = 'Add Supplier';
      $supplier_no = generateSupplierNumber();
      return view('webmaster.suppliers.create', compact('page_title', 'supplier_no'));
   }

   public function supplierStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'telephone'   => 'required|numeric',
        'email'   => 'required',
        'address'   => 'required'
      ], [
         'name.required'               => 'The name is required.',
         'telephone.required'          => 'The telephone is required',
         'email.required'              => 'The email is required',
         'address.required'            => 'The address is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $supplier = new Supplier();
      $supplier->supplier_no           = $request->supplier_no;
      $supplier->name                  = $request->name;
      $supplier->telephone             = $request->telephone;
      $supplier->email                 = $request->email;
      $supplier->address               = $request->address;
      $supplier->save();

      $notify[] = ['success', 'Supplier added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.suppliers')
      ]);
   }

   
}