<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Admin;
use App\Models\Module;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function roles()
   {
      $page_title = 'Roles';
      $roles = Role::all();
      return view('webmaster.roles.index', compact('page_title', 'roles'));
   }

   public function roleCreate()
   {
      $page_title = 'Create Role';
      $modules = Permission::groupBy('module_name')->get();
      return view('webmaster.roles.create', compact('page_title', 'modules'));
   }

   public function roleStore(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'description' => 'required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $role = new Role();
      $role->name = strtoupper($request->name);
      $role->description = $request->description;
      $role->save();

      // foreach($request->permission_id as $row){
      //    $permission = new RolePermission();
      //    $permission->permission_id = $row;
      //    $permission->role_id = $role->id;
      //    $permission->save();
      // }

      $notify[] = ['success', 'Role created successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.roles')
      ]);

   }

   public function roleEdit($id) 
   {
      $role = Role::findOrFail($id);
      $modules = Permission::groupBy('module_name')->get();
      $page_title = 'Edit Role';
      return view('webmaster.roles.edit', compact('page_title', 'role', 'modules'));
   }


   public function roleUpdate(Request $request)
    {
      $role_id = $request->id;
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'description' => 'required'
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }

      $role = Role::find($role_id);
      $role->name = strtoupper($request->name);
      $role->description = $request->description;
      $role->save();

      $existing_role_permissions = RolePermission::where('role_id', $role_id)->get();
         foreach ($existing_role_permissions as $role_permission) {
            $role_permission->delete();
      }

      foreach($request->permission_id as $row){
         $permission = new RolePermission();
         $permission->permission_id = $row;
         $permission->role_id = $role_id;
         $permission->save();
      }

      $notify[] = ['success', 'Role updated successfully!'];
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200,
        'url' => route('webmaster.roles')
      ]);

   }
}

