<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function accounttypes()
   {
      $page_title = 'Account Types';
      $accounttypes = AccountType::all();
      return view('webmaster.accounttypes.index', compact('page_title', 'accounttypes'));
   }

   public function accounttypeCreate()
   {
      $page_title = 'Add Account Type';
      return view('webmaster.accounttypes.create', compact('page_title'));
   }

   public function accounttypeStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'min_amount'   => 'required|numeric',
        'description'   => 'required'
      ], [
         'name.required'               => 'The name is required.',
         'min_amount.required'         => 'The minimum amount is required.',
         'description.required'        => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $account = new AccountType();
      $account->name                = $request->name;
      $account->min_amount          = $request->min_amount;
      $account->description         = $request->description;
      $account->save();

      $notify[] = ['success', 'Account Type added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.accounttypes')
      ]);
   }
}
