<?php

namespace Database\Seeders;

use App\Models\staffMember;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $superadminRole = Role::firstOrCreate([
            'name' => 'Superadmin',
            'guard_name' => 'webmaster'
        ]);
        
        $allPermissions = Permission::where('guard_name', 'webmaster')->get();
        $superadminRole->syncPermissions($allPermissions);

        $staff = staffMember::create([
            'fname' => 'Jajja',
            'lname' => 'Felix',
            'email' => 'kiboolif@gmail.com',
            'password' => bcrypt('superadmin'),
            'role_id' => $superadminRole->id,
            'branch_id'=>1
        ]);
        $staff->assignRole($superadminRole);
    }
}
