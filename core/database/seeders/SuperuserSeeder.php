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
            'name' => 'superadmin',
            'guard_name' => 'webmaster'
        ]);
        
        $allPermissions = Permission::where('guard_name', 'webmaster')->get();
        $superadminRole->syncPermissions($allPermissions);

        // Step 3: Create a new staff member
        $staff = staffMember::create([
            'fname' => 'Jajja',
            'lname' => 'Felix',
            'email' => 'devjajja@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $superadminRole->id,
        ]);
    }
}
