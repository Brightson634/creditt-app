<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Tenants;
use App\Models\StaffMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Simulated "request" data
        $data = [
            'business_name' => 'Sovereign Holdings',
            'address' => 'Plot 77 Masaba Road, Mbale',
            'business_contact' => '+256700000001',
            'alternate_contact' => '+256700000002',
            'entity_email' => 'info@sovereignholdings.com',
            'alternate_email' => 'admin@sovereignholdings.com',

            'title' => 'Mr.',
            'fname' => 'Felix',
            'lname' => 'Kibooli',
            'email' => 'kiboolif@sovereignholdings.com',
            'phone' => '+256701234567',
            'password' => 'admin123',
        ];

        //Save business entity (Tenant)
        $tenant = new Tenants();
        $tenant->physical_location = $data['address'];
        $tenant->company_name = $data['business_name'];
        $tenant->phone_contact_one = $data['business_contact'];
        $tenant->phone_contact_two = $data['alternate_contact'];
        $tenant->email_address_one = $data['entity_email'];
        $tenant->email_address_two = $data['alternate_email'];
        $tenant->save();
        $lastInsertedId = $tenant->id;

        //default or head branch
        $branch = new Branch();
        $branch->tenant_id = $lastInsertedId;
        $branch->branch_no = 'BR00' . $lastInsertedId;
        $branch->name = 'Main Branch';
        $branch->is_main = 1;
        $branch->default_currency = 0;
        $branch->save();

        //Superadmin role
        $superadmin = Role::firstOrCreate([
            'name' => 'Superadmin',
            'guard_name' => 'webmaster',
            'tenant_id' => $lastInsertedId,
            'is_default' => true,
        ]);

        $allPermissions = Permission::where('guard_name', 'webmaster')->get();
        $superadmin->syncPermissions($allPermissions);

        //Create Super Admin User
        $staff = new StaffMember();
        $staff->title = $data['title'];
        $staff->fname = $data['fname'];
        $staff->lname = $data['lname'];
        $staff->tenant_id = $lastInsertedId;
        $staff->email = $data['email'];
        $staff->telephone = $data['phone'];
        $staff->password = Hash::make($data['password']);
        $staff->staff_no = 'SUPADM00' . $lastInsertedId;
        $staff->branch_id = $branch->id;
        $staff->role_id = $superadmin->id;
        $staff->save();
        $staff->assignRole($superadmin);
    }
}
