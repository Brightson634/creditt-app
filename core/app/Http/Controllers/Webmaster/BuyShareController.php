<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\BuyShare;
use App\Models\Member;
use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuyShareController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function buyshares()
   {
      $page_title = 'Buy Shares';
      $buyshares = BuyShare::all();
      return view('webmaster.buyshares.index', compact('page_title', 'buyshares'));
   }

   public function buyshareCreate()
   {
      $page_title = 'Add Buy Shares';
      $shares = Share::all();
      $members = Member::all();
      return view('webmaster.buyshares.create', compact('page_title', 'shares', 'members'));
   }

   public function getShare($id = null)
   {
      $data = Share::find($id);
      if ($data) {
         return response()->json([
            'unit_price'  => $data->unit_price
         ]);
      }
      return response()->json([
         'unit_price' => '',
      ]);
   }

   public function buyshareStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'member_id'          => 'required',
        'share_id'         => 'required',
        'unit_buy_price'     => 'required|numeric',
        'total_share'     => 'required|numeric',
        'total_amount'       => 'required|numeric'
      ], [
         'member_id.required'           => 'The member is required.',
         'share_id.required'          => 'The  shares category is required',
         'unit_buy_price.required'      => 'The unit share price is required',
         'total_share.required'      => 'The total share is required',
         'total_amount.required'      => 'The total amount is required',
        
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $share = new  BuyShare();
      $share->member_id         = $request->member_id;
      $share->share_id          = $request->share_id;
      $share->unit_buy_price    = $request->unit_buy_price;
      $share->total_share       = $request->total_share;
      $share->total_amount      = $request->total_amount;
      $share->save();

      $notify[] = ['success', 'Buy Shares added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.buyshares')
      ]);
   }


}
