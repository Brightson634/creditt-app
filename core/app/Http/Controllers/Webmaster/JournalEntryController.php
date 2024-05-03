<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\ChartOfAccount;
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
      for($x = 0; $x < $count_items; $x++) {
         $item = new JournalItem();
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
