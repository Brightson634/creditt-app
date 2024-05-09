<?php

namespace App\Http\Controllers\Webmaster;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Saving;
use App\Models\Member;
use App\Models\MemberAccount;
use App\Models\Statement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class SavingController extends Controller
{
  public function __construct()
   { 
     $this->middleware('auth:webmaster');
   } 

   public function savings()
   {
      $page_title = 'Savings';
      $savings = Saving::orderBy('id', 'DESC')->get();
      return view('webmaster.savings.index', compact('page_title', 'savings'));
   }

   public function savingCreate()
   {
      $page_title = 'Add Savings';
      $members = Member::all();
      $accounts = MemberAccount::all();
      return view('webmaster.savings.create', compact('page_title', 'members', 'accounts'));
   }

   public function savingAsccounts($id = null)
   {
      $data = MemberAccount::where('member_id', $id)->get();
      return response()->json($data);
   }

   public function savingAccounts($id)
   {
      $accounts = MemberAccount::where('member_id', $id)->get();
      if ($accounts->isEmpty()) {
        return response()->json('<option value="">No account found</option>');
      }

      $optionsHtml = '<option value="">select account number</option>';
      foreach ($accounts as $account) {
         $optionsHtml .= '<option value="' . $account->id . '">' . $account->account_no . '</option>';
      }
      return response()->json($optionsHtml);
   }


   public function savingStore(Request $request)
   {
    
      $validator = Validator::make($request->all(), [
        'member_id'        => 'required',
        'account_id'        => 'required',
        'deposit_amount'   => 'required|numeric',
        'depositor_type' => 'required|in:1,2',
        'depositor_name' =>'required_if:depositor_type==2'
        // 'depositor_name'        => 'required',
      ], [
        'member_id.required'           => 'The member is required.',
        'account_id.required'           => 'The account number is required.',
        'deposit_amount.required'      => 'The deposit amount is required.',
        'depositor_name.required'           => 'The depositors name is required.',
        
      ]);

      $balance = MemberAccount::where('id', $request->account_id)->first();

      $saving = new Saving();
      $saving->member_id = $request->member_id;
      $saving->account_id = $request->account_id;
      $saving->deposit_amount = $request->deposit_amount;
      $saving->previous_balance = $balance->current_balance;
      $saving->current_balance = $request->deposit_amount + $balance->current_balance;
      $saving->depositor_type = $request->depositor_type;
      $saving->depositor_name = $request->depositor_name;
      $saving->save();

      $statement = new Statement();
      $statement->member_id = $request->member_id;
      $statement->account_id = $request->account_id;
      $statement->type = 'SAVINGS';
      $statement->detail = 'Savings Contribution';
      $statement->amount = $request->deposit_amount;
      $statement->status = 1;
      $statement->save();

      $account = MemberAccount::where('id', $request->account_id)->first();
      $account->current_balance += $request->deposit_amount;
      $account->available_balance += $request->deposit_amount;
      $account->save();

      $notify[] = ['success', 'Savings added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.savings')
      ]);

   }

   public function savingPdf()
   {
      $savings = Saving::orderBy('id', 'DESC')->get();

      $invoice_id = 234;

      $pdf = PDF::loadView('webmaster.savings.pdf', compact('savings'))->setPaper('a4');

      //return $pdf->download($purchase->invoice_id . '.pdf');
   
      //$pdf->save('assets/pdfs/savings/' . $invoice_id . '.pdf');
      //return redirect('assets/pdfs/savings/' . $invoice_id .'.pdf');

      return $pdf->stream('savings.pdf');
        
   }



}
