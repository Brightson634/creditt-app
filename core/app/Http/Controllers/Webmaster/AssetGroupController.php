<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\AssetGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Support\Facades\Validator;

class AssetGroupController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function assetgroups()
  {
    $page_title = 'Asset Groups';
    $assetgroups = AssetGroup::all();
    return view('webmaster.assetgroups.index', compact('page_title', 'assetgroups'));
  }

  public function assetgroupCreate()
  {
    $page_title = 'Add Asset Group';
    return view('webmaster.assetgroups.create', compact('page_title'));
  }

  public function assetgroupStore(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'        => 'required',
      'description'   => 'required'
    ], [
      'name.required'               => 'The name is required.',
      'description.required'          => 'The description is required'

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $asset = new AssetGroup();
    $asset->name          = $request->name;
    $asset->description   = $request->description;
    $asset->save();

    $notify[] = ['success', 'Asset Group added Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.assetgroups')
    ]);
  }
  public function assetgroupEdit($id)
  {
    $page_title = 'Edit Asset Group';
    $asset_group = AssetGroup::findOrFail($id);
    return view('webmaster.assetgroups.edit', compact('page_title', 'asset_group'));
  }
  public function assetgroupUpdate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'        => 'required',
      'description'   => 'required'
    ], [
      'name.required'               => 'The name is required.',
      'description.required'          => 'The description is required'

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    $asset = AssetGroup::findOrFail($request->id);
    $asset->name          = $request->name;
    $asset->description   = $request->description;
    $asset->save();

    $notify[] = ['success', 'Asset Group Updated Successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.assetgroups')
    ]);
  }
  public function assetgroupDestroy($id)
  {
    $group =AssetGroup::findOrFail($id);
    $group->delete();
    $notify[] = ['success', 'Asset Group deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Asset Group deleted successfully.');
  }
}
