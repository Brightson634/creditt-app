<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\SellShare;
use App\Models\Member;
use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SellShareController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function sellshares()
   {
      $page_title = 'Sell Shares';
      $sellshares = SellShare::all();
      return view('webmaster.sellshares.index', compact('page_title', 'sellshares'));
   }

   public function sellshareCreate()
   {
      $page_title = 'Add Sell Shares';
      $shares = Share::all();
      $members = Member::all();
      return view('webmaster.sellshares.create', compact('page_title', 'shares', 'members'));
   }

   // public function getShare($id = null)
   // {
   //    $data = Share::find($id);
   //    if ($data) {
   //       return response()->json([
   //          'unit_price'  => $data->unit_price
   //       ]);
   //    }
   //    return response()->json([
   //       'unit_price' => '',
   //    ]);
   // }

   public function sellshareStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'member_id'          => 'required',
        'share_id'         => 'required',
        'unit_sell_price'     => 'required|numeric',
        'total_share'     => 'required|numeric',
        'total_amount'       => 'required|numeric'
      ], [
         'member_id.required'           => 'The member is required.',
         'share_id.required'          => 'The  shares category is required',
         'unit_sell_price.required'      => 'The unit share price is required',
         'total_share.required'      => 'The total share is required',
         'total_amount.required'      => 'The total amount is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $share = new  SellShare();
      $share->member_id         = $request->member_id;
      $share->share_id          = $request->share_id;
      $share->unit_sell_price    = $request->unit_sell_price;
      $share->total_share       = $request->total_share;
      $share->total_amount      = $request->total_amount;
      $share->save();

      $notify[] = ['success', 'Sell Shares added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.sellshares')
      ]);
   }


}
