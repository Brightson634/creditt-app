<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Admin;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\PermissionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:webmaster');
  }

  public function roles()
  {
    $response=PermissionsService::check('view_roles');
    if($response)
    {
      return $response;
    }
    $page_title = 'Roles';
    $roles = Role::all();
    return view('webmaster.roles.index', compact('page_title', 'roles'));
  }

  public function roleCreate()
  {
    PermissionsService::check('add_role_settings');
    $page_title = 'Create Role';
    // $modules = Permission::groupBy('module_name')->get();
    $permissions = Permission::all();
    return view('webmaster.roles.create', compact('page_title', 'permissions'));
  }

  public function roleStore(Request $request)
  {
    // Validate the input
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      // 'description'=>'required';
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }

    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()
      ]);
    }
    $guardName = 'webmaster';
    $role = Role::create([
      'name' => $request->name,
      'description' => $request->description,
      'guard_name' => $guardName,
    ]);

    $notify[] = ['success', 'Role created successfully!'];
    session()->flash('notify', $notify);

    return response()->json([
      'status' => 200,
      'url' => route('webmaster.roles')
    ]);
  }

  public function roleEdit($id)
  {
    if (!Auth::guard('webmaster')->user()->can('edit_role_settings')) {
      return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized action!'
      ], 403); // HTTP 403 Forbidden
    };

    $role = Role::findOrFail($id);
    $permissions = Permission::all();
    // Get the role's assigned permissions
    $rolePermissions = $role->permissions->pluck('id')->toArray();
    // $view = view('webmaster.roles.edit', compact('page_title', 'role', 'modules'))->render();
    $view = view('webmaster.roles.editmodal', compact('role', 'permissions', 'rolePermissions'))->render();
    return response()->json(['html' => $view]);
  }

  public function roleDelete($id)
  {
    if (!Auth::guard('webmaster')->user()->can('delete_role_settings')) {
      return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized action!'
      ], 403); // HTTP 403 Forbidden
    };

    $guardName = 'webmaster';
    $role = Role::where('id', $id)
      ->where('guard_name', $guardName)
      ->first();

    if (!$role) {
      return response()->json([
        'status' => 404,
        'message' => 'Role not found!'
      ]);
    }

    $role->syncPermissions([]);

    $role->delete();

    return response()->json([
      'status' => 200,
      'message' => 'Role deleted successfully!',
      'url' => route('webmaster.roles')
    ]);
  }



  public function roleUpdate(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors(),
      ], 422);
    }

    $role = Role::findOrFail($id);

    // Update the role details
    $role->name = $request->name;
    $role->description = $request->description;
    $role->save();

    return response()->json([
      'success' => true,
      'message' => 'Role updated successfully.'
    ]);
  }
  public function roleAssignPermissions($id)
  {
    $page_title = 'Assign Permissions';
    $role = Role::findOrFail($id);
    $permissions = Permission::all();
    // Get the role's assigned permissions
    $rolePermissions = $role->permissions->pluck('id')->toArray();
    return view('webmaster.roles.permissions', compact('role', 'rolePermissions', 'permissions', 'page_title'));
  }
  public function roleAssignPermissionsStore(Request $request, $id)
  {

    $role = Role::findOrFail($id);
    $permissions = Permission::whereIn('id', $request->permissions)
      ->where('guard_name', 'webmaster')
      ->get();
    //assign selected permissions to a role
    $role->syncPermissions($permissions);
    $notify[] = ['success', 'Permissions assigned!'];
    session()->flash('notify', $notify);
    return redirect()->route('webmaster.roles')->with('success', 'Permissions assigned!');
  }
}
