<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Asset;
use App\Models\StaffMember;
use App\Models\Supplier;
use App\Models\AssetGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function assets()
   {
      $page_title = 'Assets';
      $assets = Asset::all();
      return view('webmaster.assets.index', compact('page_title', 'assets'));
   }

   public function assetCreate()
   {
      $page_title = 'Add Asset';
      $asset_no = generateAssetNumber();
      $staffs = StaffMember::all();
      $suppliers = Supplier::all();
      $assetgroups = AssetGroup::all();
      return view('webmaster.assets.create', compact('page_title', 'asset_no', 'staffs', 'suppliers', 'assetgroups'));
   }

   public function assetStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name'                  => 'required',
        'assetgroup_id'         => 'required',
        'serial_no'             => 'required',
        'cost_price'            => 'required|numeric',
        'purchase_date'         => 'required',
        'staff_id'              => 'required',
        'location'              => 'required',
        'warrant_period'        => 'required|numeric',
        'depreciation_period'   => 'required|numeric',
        'depreciation_amount'   => 'required|numeric',
        'supplier_id'           => 'required',
      ], [
        'name.required'                 => 'The name is required',
        'assetgroup_id.required'        => 'The asset group is required',
        'serial_no.required'            => 'The serial or model number is required',
        'cost_price.required'           => 'The cost price is required',
        'purchase_date.required'        => 'The purchase date is required',
        'staff_id.required'             => 'The staff is required',
        'location.required'             => 'The location is required',
        'warrant_period.required'       => 'The warrant period is required',
        'depreciation_period.required'  => 'The depreciation period is required.',
        'depreciation_amount.required'  => 'The depreciation amount is required.',
        'supplier_id.required'          => 'The supplier  is required.',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

        $asset = new Asset();
        $asset->asset_no = $request->asset_no;
        $asset->name = $request->name;
        $asset->assetgroup_id = $request->assetgroup_id;
        $asset->serial_no = $request->serial_no;
        $asset->cost_price = $request->cost_price;
        $asset->purchase_date = $request->purchase_date;
        $asset->staff_id = $request->staff_id;
        $asset->location = $request->location;
        $asset->warrant_period = $request->warrant_period;
        $asset->depreciation_period = $request->depreciation_period;
        $asset->depreciation_amount = $request->depreciation_amount;
        $asset->supplier_id = $request->supplier_id;
        $asset->save();

      $notify[] = ['success', 'Asset added Successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.assets')
      ]);
   }

   


}
