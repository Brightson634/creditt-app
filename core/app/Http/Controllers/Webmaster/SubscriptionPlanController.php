<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function subscriptionplans()
   {
      $page_title = 'Subscription Plans';
      $plans = SubscriptionPlan::all();
      return view('webmaster.subscriptionplans.index', compact('page_title', 'plans'));
   }

   public function subscriptionplanCreate()
   {
      $page_title = 'Add Subscription Plan';
      return view('webmaster.subscriptionplans.create', compact('page_title'));
   }

   public function subscriptionplanStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'description'   => 'required'
      ], [
         'name.required'               => 'The name is required.',
         'description.required'          => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $plan = new SubscriptionPlan();
      $plan->name          = $request->name;
      $plan->description   = $request->description;
      $plan->save();

      $notify[] = ['success', 'Plan added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.subscriptionplans')
      ]);
   }
}
