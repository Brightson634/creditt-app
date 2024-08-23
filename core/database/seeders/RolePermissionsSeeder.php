<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\staffMember;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Check if permission already exists before creating
         $permissions = [
             'review loans',
             'approve loans',
             'reject loans',
             'manage users',
             'manage roles',
         ];
 
         foreach ($permissions as $permission) {
             if (!Permission::where('name', $permission)->where('guard_name', 'webmaster')->exists()) {
                 Permission::create(['name' => $permission, 'guard_name' => 'webmaster']);
             }
         }
 
         // Create roles for 'Webmaster' guard
         $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'webmaster']);
         $officer = Role::firstOrCreate(['name' => 'Officer', 'guard_name' => 'webmaster']);
         $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'webmaster']);
         $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'webmaster']);
 
         // Assign roles to staff members
         $staffMember1 = staffMember::find(1); 
         if ($staffMember1) {
             $staffMember1->assignRole('Super Admin', 'webmaster');
         }
 
         $staffMember2 = staffMember::find(2);
         if ($staffMember2) {
             $staffMember2->assignRole('Officer', 'webmaster');
         }
 
         $staffMember3 = staffMember::find(3);
         if ($staffMember3) {
             $staffMember3->assignRole('Manager', 'webmaster');
         }
 
         $staffMember4 = staffMember::find(4);
         if ($staffMember4) {
             $staffMember4->assignRole('Supervisor', 'webmaster');
         }
    }
}
