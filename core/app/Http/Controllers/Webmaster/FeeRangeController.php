<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\FeeRange;
use App\Models\Fee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FeeRangeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function feeranges()
  {
    $page_title = 'Fee Ranges';
    $feeranges = FeeRange::all();
    return view('webmaster.feeranges.index', compact('page_title', 'feeranges'));
  }

  public function feerangeCreate()
  {
    $page_title = 'Add Fee Range';
    $fees = Fee::where('rate_type', 'range')->get();
    return view('webmaster.feeranges.create', compact('page_title', 'fees'));
  }

  public function feerangeStore(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'fee_id'        => 'required',
      'min_amount'   => 'required|numeric',
      'max_amount'   => 'required|numeric',
      'amount'   => 'required|numeric'
    ], [
      'fee_id.required'             => 'The fee is required.',
      'min_amount.required'         => 'The minimum amount is required',
      'min_amount.numeric'          => 'The minimum amount should be a number value',
      'max_amount.required'         => 'The maximum amount is required',
      'max_amount.numeric'          => 'The maximum amount should be a number value',
      'amount.required'             => 'The amount is required',
      'amount.numeric'              => 'The amount should be a number value',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $range = new FeeRange();
    $range->fee_id     = $request->fee_id;
    $range->min_amount = $request->min_amount;
    $range->max_amount = $request->max_amount;
    $range->amount     = $request->amount;
    $range->save();

    $notify[] = ['success', 'Fee Range added Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.feeranges')
    ]);
  }

  public function feerangeEdit($id)
  {
    $page_title = 'Update Fee Range';
    $feerange = FeeRange::findOrFail($id);
    $fees = Fee::where('rate_type', 'range')->get();
    return view('webmaster.feeranges.edit', compact('page_title', 'fees', 'feerange'));
  }

  public function feerangeUpdate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'fee_id'        => 'required',
      'min_amount'   => 'required|numeric',
      'max_amount'   => 'required|numeric',
      'amount'   => 'required|numeric'
    ], [
      'fee_id.required'             => 'The fee is required.',
      'min_amount.required'         => 'The minimum amount is required',
      'min_amount.numeric'          => 'The minimum amount should be a number value',
      'max_amount.required'         => 'The maximum amount is required',
      'max_amount.numeric'          => 'The maximum amount should be a number value',
      'amount.required'             => 'The amount is required',
      'amount.numeric'              => 'The amount should be a number value',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $range = FeeRange::findORFail($request->id);
    $range->fee_id     = $request->fee_id;
    $range->min_amount = $request->min_amount;
    $range->max_amount = $request->max_amount;
    $range->amount     = $request->amount;
    $range->save();

    $notify[] = ['success', 'Fee Range Updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.feeranges')
    ]);
  }

  public function feerangeDestroy($id)
  {
    $feerange = FeeRange::findOrFail($id);
    $feerange->delete();
    $notify[] = ['success', 'Fee Range deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Fee Range deleted successfully.');
  }
}
