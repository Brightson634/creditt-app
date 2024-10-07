<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Asset;
use App\Models\AssetGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetGroupController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function assetgroups()
  {
    PermissionsService::check('view_assets_group');
    $page_title = 'Asset Groups';
    $assetgroups = AssetGroup::all();
    return view('webmaster.assetgroups.index', compact('page_title', 'assetgroups'));
  }

  public function assetgroupCreate()
  {
    PermissionsService::check('add_assets_group');
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
    PermissionsService::check('edit_assets_group','Anauthorized action!');
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
    if (!Auth::guard('webmaster')->user()->can('delete_assets_group')) {
      $notify[] = ['error', 'Unauthorized Action!'];
      session()->flash('notify', $notify);
      return redirect()->back()->send();
    }
    $group =AssetGroup::findOrFail($id);
    $group->delete();
    $notify[] = ['success', 'Asset Group deleted successfully!'];
    session()->flash('notify', $notify);
    return redirect()->back()->with('success', 'Asset Group deleted successfully.');
  }
}
