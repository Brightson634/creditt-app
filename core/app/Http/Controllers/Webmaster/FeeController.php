<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ChartOfAccount;


class FeeController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function fees()
   {
      $page_title = 'Fees';
      $fees = Fee::all();
      $accounts = ChartOfAccount::all();
      return view('webmaster.fees.index', compact('page_title', 'fees','accounts'));
   }

   public function feeCreate()
   {
      $page_title = 'Add Fee';
      $accounts = ChartOfAccount::all();
      return view('webmaster.fees.create', compact('page_title','accounts'));
   }

   public function feeStore(Request $request)
   {
      $rules = [
        'account_id'      => 'required',
        'name'            => 'required',
        'type'            => 'required',
        'rate_type'       => 'required',
        'period'          => 'required',
      ];
      
      $messages = [
         'account_id.required' => 'The account is required.',
         'name.required'       => 'The fee name are required.',
         'type.required'       => 'The fee type are required',
         'rate_type.required'  => 'The fee rate type is required',
         'period.required'     => 'The fee period type is required'
      ];

      if ($request->rate_type == 'fixed') {
         $rules += [
            'amount'        => 'required|numeric',
         ];
            
         $messages += [
            'amount.required'    => 'The amount is required',
            'amount.numeric'     => 'The amount should be a number value',
         ];
      }
      if ($request->rate_type == 'percent') {
         $rules += [
            'rate'        => 'required|numeric',
         ];
            
         $messages += [
            'rate.required'    => 'The rate is required',
            'rate.numeric'     => 'The rate should be a number value',
         ];
      }

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return response()->json([
            'status' => 400,
            'message' => $validator->errors()
         ]);
      }

      $fee = new Fee();
      $fee->name = $request->name;
      $fee->type = $request->type;
      $fee->rate_type = $request->rate_type;
      $fee->period = $request->period;
      $fee->amount = ($request->rate_type == 'fixed') ? $request->amount : 0;
      if ($request->rate_type == 'percent') {
         $fee->rate = $request->rate;
         $fee->rate_value = $request->rate / 100;
      }
      $fee->account_id = $request->account_id;

      $fee->save();

      insertAccountTransaction($request->account_id, 'CREDIT', $request->amount, $request->description);


      $notify[] = ['success', 'Fee added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.fees')
      ]);
   }





}
