<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Admin;
use App\Models\Module;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function roles()
   {
      $page_title = 'Roles';
      // dd('roles');
      $roles = Role::all();
      return view('webmaster.roles.index', compact('page_title', 'roles'));
   }

   public function roleCreate()
   {
      $page_title = 'Create Role';
      // $modules = Permission::groupBy('module_name')->get();
      $permissions = Permission::all();
      return view('webmaster.roles.create', compact('page_title','permissions'));
   }

   public function roleStore(Request $request)
   {
       // Validate the input
       $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        // 'description'=>'required',
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id',
      ]);

      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }
      
      if($validator->fails()){
        return response()->json([
          'status' => 400,
          'message' => $validator->errors()
        ]);
      }
    $guardName = 'webmaster';
    $role = Role::create([
        'name' => $request->name,
        'guard_name' => $guardName,
    ]);
    $permissions = Permission::whereIn('id', $request->permissions)
                              ->where('guard_name', $guardName)
                              ->get();
    // Assign the selected permissions to the role
    $role->syncPermissions($permissions);


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
      $permissions = Permission::all();
      // Get the role's assigned permissions
      $rolePermissions = $role->permissions->pluck('id')->toArray();
      // $view = view('webmaster.roles.edit', compact('page_title', 'role', 'modules'))->render();
      $view= view('webmaster.roles.editmodal', compact('role', 'permissions', 'rolePermissions'))->render();
      return response()->json(['html'=>$view]);
   }


   public function roleUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          // 'description' => 'nullable|string',
          'permissions' => 'required|array',
      ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $role = Role::findOrFail($id);

        // Update the role details
        $role->name = $request->name;
        // $role->description = $request->description;
        $role->save();

        // Sync role permissions
        $role->permissions()->sync($request->permissions);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.'
        ]);
   }
}

