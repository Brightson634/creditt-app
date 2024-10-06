<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\LoanProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function loanproducts()
  {
   
    PermissionsService::check('view_loan_products');

    $page_title = 'Loan Products';
    $loanproducts = LoanProduct::all();
    return view('webmaster.loanproducts.index', compact('page_title', 'loanproducts'));
  }

  public function loanproductCreate()
  {
    PermissionsService::check('add_loan_product');
    $page_title = 'Add Loan Product';
    return view('webmaster.loanproducts.create', compact('page_title'));
  }

  public function loanproductStore(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'                => 'required',
      'min_amount'          => 'required|numeric',
      'max_amount'          => 'required|numeric',
      'interest_rate'       => 'required|numeric',
      'duration'            => 'required'
    ], [
      'name.required'                  => 'The name is required.',
      'min_amount.required'            => 'The  minimum amount is required',
      'max_amount.required'            => 'The maximum amount is required',
      'interest_rate.required'         => 'The interest rate is required',
      'duration.required'              => 'The duration is required',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $product = new  LoanProduct();
    $product->name                = $request->name;
    $product->min_amount          = $request->min_amount;
    $product->max_amount          = $request->max_amount;
    $product->interest_rate       = $request->interest_rate;
    $product->interest_value      = $request->interest_rate / 100;
    $product->duration            = $request->duration;
    $product->cust_acc_balance = $request->cust_acc_balance;
    $product->save();

    $notify[] = ['success', 'Product added Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.loanproducts')
    ]);
  }
  public function loanProductEdit($id)
  {
    PermissionsService::check('edit_loan_product','Unauthorized Action!');
    $page_title = 'Edit Loan Product';
    $loanproduct = LoanProduct::findOrFail($id);
    return view('webmaster.loanproducts.edit', compact('page_title','loanproduct'));
  }
  public function loanproductUpdate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'                => 'required',
      'min_amount'          => 'required|numeric',
      'max_amount'          => 'required|numeric',
      'interest_rate'       => 'required|numeric',
      'duration'            => 'required'
    ], [
      'name.required'                  => 'The name is required.',
      'min_amount.required'            => 'The  minimum amount is required',
      'max_amount.required'            => 'The maximum amount is required',
      'interest_rate.required'         => 'The interest rate is required',
      'duration.required'              => 'The duration is required',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $product = LoanProduct::findOrFail($request->id);
    $product->name                = $request->name;
    $product->min_amount          = $request->min_amount;
    $product->max_amount          = $request->max_amount;
    $product->interest_rate       = $request->interest_rate;
    $product->interest_value      = $request->interest_rate / 100;
    $product->duration            = $request->duration;
    $product->cust_acc_balance = $request->cust_acc_balance;
    $product->save();

    $notify[] = ['success', 'Product info updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.loanproducts')
    ]);
  }
  public function loanproductDestroy($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_loan_product')) {
      $notify[] = ['error', 'Unauthorized action'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
  }
    $loanproduct = LoanProduct::findOrFail($id);
    $loanproduct->delete();
    $notify[] = ['success', 'Loan Product deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Loan Product deleted successfully.');
  }
}
