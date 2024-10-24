<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ShareController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function shares()
   {
      $page_title = 'Shares';
      $shares = Share::all();
      return view('webmaster.shares.index', compact('page_title', 'shares'));
   }

   public function shareCreate()
   {
      $page_title = 'Add Shares';
      return view('webmaster.shares.create', compact('page_title'));
   }

   public function shareStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'                => 'required',
        'unit_price'          => 'required|numeric',
        'total_share'         => 'required|numeric',
        'min_total_share'     => 'required|numeric',
        'max_total_share'     => 'required|numeric',
        'min_buy_price'       => 'required|numeric'
      ], [
         'name.required'                  => 'The share name required.',
         'unit_price.required'            => 'The unit price is required.',
         'total_share.required'           => 'The total shares is required',
         'min_total_share.required'       => 'The minimum total share is required',
         'max_total_share.required'       => 'The maximum total share is required',
         'min_buy_price.required'         => 'The minimum buy price is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $share = new Share();
      $share->name                  = $request->name;
      $share->unit_price            = $request->unit_price;
      $share->total_share           = $request->total_share;
      $share->min_total_share       = $request->min_total_share;
      $share->max_total_share       = $request->max_total_share;
      $share->min_buy_price         = $request->min_buy_price;
      $share->save();

      $notify[] = ['success', 'Shares added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.shares')
      ]);
   }
}
