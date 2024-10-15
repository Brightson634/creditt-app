<?php

namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Models\InvestmentPlan;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvestmentPlanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function investmentplans()
  {
    $response=PermissionsService::check('view_investment_plan');
    if($response)
    {
      return $response;
    }
    $page_title = 'Investment Plans';
    $investmentplans = InvestmentPlan::all();
    return view('webmaster.investmentplans.index', compact('page_title', 'investmentplans'));
  }

  public function investmentplanCreate()
  {
    $response = PermissionsService::check('add_investment_plan');
    if($response)
    {
      return $response;
    }
    $page_title = 'Add Investment Plan';
    return view('webmaster.investmentplans.create', compact('page_title'));
  }

  public function investmentplanStore(Request $request)
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

    $plan = new  InvestmentPlan();
    $plan->name                = $request->name;
    $plan->min_amount          = $request->min_amount;
    $plan->max_amount          = $request->max_amount;
    $plan->interest_rate       = $request->interest_rate;
    $plan->interest_value      = $request->interest_rate / 100;
    $plan->duration            = $request->duration;
    $plan->save();

    $notify[] = ['success', 'Plan added Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.investmentplans')
    ]);
  }
  public function investmentplanEdit($id)
  {
    PermissionsService::check('edit_investment_plan');
    $page_title = 'Update Investment Plan';

    $investmentplan = InvestmentPlan::findOrFail($id);
    return view('webmaster.investmentplans.edit', compact('investmentplan', 'page_title'));
  }
  public function investmentplanUpdate(Request $request)
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

    $plan = InvestmentPlan::findOrFail($request->id);
    $plan->name                = $request->name;
    $plan->min_amount          = $request->min_amount;
    $plan->max_amount          = $request->max_amount;
    $plan->interest_rate       = $request->interest_rate;
    $plan->interest_value      = $request->interest_rate / 100;
    $plan->duration            = $request->duration;
    $plan->save();

    $notify[] = ['success', 'Plan Updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.investmentplans')
    ]);
  }
  public function investmentplanDestroy($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_investment_plan')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    $investmentplan = InvestmentPlan::findOrFail($id);
    $investmentplan->delete();
    $notify[] = ['success', 'Investment plan deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Investmentplan deleted successfully.');
  }
}
