<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Saving;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SavingController extends Controller
{
   public function __construct()
   { 
     $this->middleware('auth:member');
   }


   public function mysavings()
   {
      $page_title = 'Savings';
      $setting = Setting::first();
      $mysavings = Saving::where('member_id', member()->id)->orderBy('id', 'DESC')->get();
      return view('member.savings.mysavings', compact('page_title','mysavings'));
   }

    public function savingCreate()
   {
      $page_title = 'Make Savings';
      
      return view('member.savings.create', compact('page_title', ''));
   }

   public function savingStore(Request $request)
   {
      $setting = Setting::first();

      $validator = Validator::make($request->all(), [
        'deposit_amount'   => 'required|numeric',
        'member_id'     => 'required'
      ], [
        'deposit_amount.required'  => 'The deposit amount is required.',
        'deposit_amount.numeric'   => 'The deposit amount should be a value',
        'member_id.required'       => 'Please select the member',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $saving = new Saving();
      $saving->savingyear_id = $request->savingyear_id;
      $saving->savingweek_id = $request->savingweek_id;
      $saving->member_id = $request->member_id;
      $saving->deposit_amount = $request->deposit_amount;
      $saving->savings_amount = $request->savings_amount;
      $saving->welfare_amount = $request->welfare_amount;
      $saving->agent_id = member()->id;
      $saving->date = date('Y-m-d');
      $saving->save();

      $membersaving = MemberSaving::where('member_id', $request->member_id)->where('savingyear_id', $request->savingyear_id)->first();
      $membersaving->deposit_amount += $request->deposit_amount;
      $membersaving->savings_amount += $request->savings_amount;
      $membersaving->welfare_amount += $request->welfare_amount;
      $membersaving->save();

      $savingyear = SavingYear::where('id', $request->savingyear_id)->first();
      $savingyear->deposit_amount += $request->deposit_amount;
      $savingyear->savings_amount += $request->savings_amount;
      $savingyear->welfare_amount += $request->welfare_amount;
      $savingyear->save();

      $savingweek = SavingWeek::where('id', $request->savingweek_id)->first();
      $savingweek->total_members += 1;
      $savingweek->deposit_amount += $request->deposit_amount;
      $savingweek->savings_amount += $request->savings_amount;
      $savingweek->welfare_amount += $request->welfare_amount;
      $savingweek->save();



      $memberNotification = new MemberNotification();
      $memberNotification->savingyear_id = $request->savingyear_id;
      $memberNotification->member_id = $request->member_id;
      $memberNotification->type = 'SAVING';
      $memberNotification->title = 'Savings Amount Made';
      $memberNotification->detail = 'Your have successfully saved amount of ' .showAmount($request->deposit_amount);
      $memberNotification->url = NULL;
      $memberNotification->save();

      $notify[] = ['success', 'Savings added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('member.savings')
      ]);

   }
}
