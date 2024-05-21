<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\ChartOfAccount;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JournalEntryController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function journalentries()
   {
      $page_title = 'Journal Entry';
      $journalentries = JournalEntry::all();
      return view('webmaster.journalentries.index', compact('page_title', 'journalentries'));
   }

   public function journalentryCreate()
   {
      $page_title = 'Add Journal Entry';
      $journalno = generateJournalEntryNumber();
      $accounts = ChartOfAccount::all();
      return view('webmaster.journalentries.create', compact('page_title', 'journalno', 'accounts'));
   }

   public function journalentryStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'date'             => 'required',
        'description'      => 'required'
      ], [
        'date.required'             => 'The transaction date are required.',
        'description.required'      => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $journal = new JournalEntry();
      $journal->journal_no = $request->journal_no;
      $journal->description = $request->description;
      $journal->total_debit = $request->total_debit;
      $journal->total_credit = $request->total_credit;
      $journal->date = $request->date;
      $journal->save();



      $count_items = count($request->account_id);
      // dd($accountData);
      for($x = 0; $x < $count_items; $x++) {
         $item = new JournalItem();
        
        
         $account = ChartOfAccount::where('id',$request->account_id[$x])->first();
         $tx = new AccountTransaction();
         if ($account) {
             
             if ($request->debit_amount[$x] > 0) {
                 $previous_amnt = $account->opening_balance;
                 $account->opening_balance -= $request->debit_amount[$x];
                 $tx->account_id =  $account->id;
                 $tx->type = 'DEBIT';
                 $tx->previous_amount = $previous_amnt;
                 $tx->amount =$request->debit_amount[$x];
                 $tx->current_amount = $account->opening_balance;
                 $tx->description = $request->description;
                 $tx->date = $request->date;
             }
             if ($request->credit_amount[$x] > 0) {
                 $previous_amt = $account->opening_balance;
                 $account->opening_balance += $request->credit_amount[$x];
                 $tx->account_id = $account->id;
                 $tx->type = 'CREDIT';
                 $tx->previous_amount = $previous_amt;
                 $tx->amount = $request->credit_amount[$x];
                 $tx->current_amount = $account->opening_balance;
                 $tx->description = $request->description;
                 $tx->date = $request->date;
             }
             $account->save();
             $tx->save();

         }


     
         $item->journal_id = $journal->id;
         $item->account_id = $request->account_id[$x];
         $item->debit_amount = $request->debit_amount[$x];
         $item->credit_amount = $request->credit_amount[$x];
         $item->save();
      }

      $notify[] = ['success', 'Journal Entry added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.journalentries')
      ]);
   }


}
