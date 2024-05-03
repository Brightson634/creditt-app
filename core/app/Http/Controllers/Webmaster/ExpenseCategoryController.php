<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
     public function __construct()
   {
     $this->middleware('auth:webmaster');
   }
 
   public function expensecategories()
   {
      $page_title = 'Expense Categories';
      $categories = ExpenseCategory::where('is_subcat', 0)->get();
      return view('webmaster.expensecategories.index', compact('page_title', 'categories',));
   }

   public function accounttypeCreate()
   {
      $page_title = 'Add Account Type';
      return view('webmaster.accounttypes.create', compact('page_title'));
   }

   public function expensecategoryStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'        => 'required',
        'code'        => 'required',
        'description'   => 'required'
      ], [
         'name.required'               => 'The name is required',
         'code.required'               => 'The code is required',
         'description.required'        => 'The description is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

         $category = new ExpenseCategory();
         $category->name             = $request->name;
         $category->code             = $request->code;
         $category->is_subcat        = $request->has('is_subcat') ? 1 : 0;
         if($request->has('is_subcat')) {
            $category->parent_id     = $request->parent_id;
         }
         $category->description      = $request->description;
         $category->save();
      

      $notify[] = ['success', 'Expense Category added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        //'url' => route('webmaster.accounttypes')
      ]);
   }
}
