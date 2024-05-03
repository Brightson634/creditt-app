<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\BranchPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchPositionController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function branchpositions()
    {
      $page_title = 'Branch Positions';
      $branchpositions = BranchPosition::all();
      return view('webmaster.branchpositions.index', compact('page_title', 'branchpositions'));
    }

    public function branchpositionStore(Request $request)
    {
      $validator = Validator::make($request->all(), [
         'name' => 'required',
         'description' => 'required'
      ], 
      [
         'name.required' => 'The position name is required',
         'description.required' => 'The position description is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

        $branchposition = new BranchPosition();
        $branchposition->name = $request->name;
        $branchposition->description = $request->description;
        $branchposition->save();


      $notify[] = ['success', 'Branch Position added successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

    }

    public function branchpositionUpdate(Request $request)
    {
     $branchposition_id = $request->id;
      $validator = Validator::make($request->all(), [
         'name' => 'required',
         'description' => 'required'
      ], 
      [
         'name.required' => 'The position name is required',
         'description.required' => 'The position description is required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

        $branchposition = BranchPosition::find($branchposition_id);
        $branchposition->name = $request->name;
        $branchposition->description = $request->description;
        $branchposition->save();


      $notify[] = ['success', 'Branch Position updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);

    }
}
