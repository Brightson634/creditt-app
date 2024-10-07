<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function suppliers()
  {
    PermissionsService::check('view_assets_supplier');
    $page_title = 'Supplier';
    $suppliers = Supplier::all();
    return view('webmaster.suppliers.index', compact('page_title', 'suppliers'));
  }

  public function supplierCreate()
  {
    PermissionsService::check('add_assets_supplier');
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

    if ($validator->fails()) {
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

  public function supplierEdit($id)
  {
    PermissionsService::check('edit_assets_supplier');
    $page_title = 'Edit Supplier';
    $supplier = Supplier::findOrFail($id);
    // $supplier_no = generateSupplierNumber();
    return view('webmaster.suppliers.edit', compact('page_title', 'supplier', 'page_title'));
  }
  public function supplierUpdate(Request $request)
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

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $supplier = Supplier::findOrFail($request->id);
    $supplier->supplier_no           = $request->supplier_no;
    $supplier->name                  = $request->name;
    $supplier->telephone             = $request->telephone;
    $supplier->email                 = $request->email;
    $supplier->address               = $request->address;
    $supplier->save();

    $notify[] = ['success', 'Supplier updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.suppliers')
    ]);
  }

  public function supplierDestroy($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_assets_supplier')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    $supplier = Supplier::findOrFail($id);
    $supplier->delete();
    $notify[] = ['success', 'Supplier deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Supplier deleted successfully.');
  }
}
