<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\ChartOfAccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChartOfAccountTypeController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function accounttypes()
   {
      $page_title = 'Account Types';
      $accounttypes = ChartOfAccountType::where('is_subaccount', 0)->get();
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
        'description'   => 'required'
      ], [
         'name.required'               => 'The name is required.',
         'description.required'        => 'The description is required'
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $account = new ChartOfAccountType();
      $account->name             = $request->name;
      $account->is_subaccount        = $request->has('is_subaccount') ? 1 : 0;
      if($request->has('is_subaccount')) {
         $account->parent_id     = $request->parent_id;
      }
      $account->description      = $request->description;
      $account->save();

      $notify[] = ['success', 'Account Type added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
   }
}
