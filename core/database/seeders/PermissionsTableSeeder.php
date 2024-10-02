<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            // Loan Permissions
            ['name' => 'review loans'],
            ['name' => 'approve loans'],
            ['name' => 'reject loans'],
            ['name' => 'edit loans'],
            ['name' => 'delete loans'],
            ['name' => 'disburse loans'],
            ['name' => 'view loans'],
            ['name' => 'add loan product'],
            ['name' => 'edit loan product'],
            ['name' => 'delete loan product'],
            ['name' => 'add loan repayment'],
            ['name' => 'edit loan repayment'],
            ['name' => 'delete loan repayment'],
            ['name' => 'edit payment'],

            // Accounting Permissions
            ['name' => 'view accounting records'],
            ['name' => 'create transactions'],
            ['name' => 'edit transactions'],
            ['name' => 'delete transactions'],
            ['name' => 'approve transactions'],
            ['name' => 'view reports'],
            ['name' => 'export reports'],
            ['name' => 'manage invoices'],
            ['name' => 'manage payments'],
            ['name' => 'manage budgets'],
            ['name' => 'view audit logs'],
            ['name' => 'reconcile accounts'],
            ['name' => 'access payroll'],
            ['name' => 'manage tax information'],

            // Staff Permissions
            ['name' => 'add staff'],
            ['name' => 'edit staff'],
            ['name' => 'delete staff'],
            ['name' => 'view staff'],
        

            // Members Permissions
            ['name' => 'add members'],
            ['name' => 'edit members'],
            ['name' => 'delete members'],
            ['name' => 'view members'],
            ['name' => 'add member account'],
            ['name' => 'edit member account'],
            ['name' => 'delete member account'],

            // Settings Permissions
            ['name' => 'access settings'],
            ['name' => 'update settings'],
            ['name' => 'delete settings'],
            ['name' => 'view settings'],

            // Roles Permissions
            ['name' => 'create roles'],
            ['name' => 'edit roles'],
            ['name' => 'delete roles'],
            ['name' => 'assign roles'],
            ['name' => 'view roles'],

            // Reports Permissions
            ['name' => 'generate reports'],
            ['name' => 'view reports'],
            ['name' => 'export reports'],
            ['name' => 'delete reports'],

            // Funds Manager Permissions
            ['name' => 'add deposits'],
            ['name' => 'edit deposits'],
            ['name' => 'view deposits'],        
            ['name' => 'delete deposits'],      
            ['name' => 'add withdrawals'],      
            ['name' => 'edit withdrawals'],     
            ['name' => 'view withdrawals'],     
            ['name' => 'delete withdrawals'],   
            ['name' => 'add transfers'],
            ['name' => 'edit transfers'],
            ['name' => 'view transfers'],       
            ['name' => 'delete transfers'],     

            // Investments Permissions
            ['name' => 'add investments'],
            ['name' => 'edit investments'],
            ['name' => 'view investments'],
            ['name' => 'delete investments'],
            ['name' => 'view investments'],
            ['name' => 'add investors'],
            ['name' => 'edit investors'],
            ['name' => 'delete investors'],
            ['name' => 'view investors'],


            // Savings Permissions
            ['name' => 'add savings'],
            ['name' => 'delete savings'],
            ['name' => 'edit savings'],
            ['name' => 'view savings'],

            // Assets Permissions
            ['name' => 'add assets'],
            ['name' => 'edit assets'],
            ['name' => 'delete assets'],
            ['name' => 'view assets'],

            // Expenses Permissions
            ['name' => 'add expenses'],
            ['name' => 'edit expenses'],
            ['name' => 'delete expenses'],
            ['name' => 'view expenses'],
            ['name' => 'add category'],
            ['name' => 'delete category'],
            ['name' => 'view category'],
            ['name' => 'edit category'],

            //dashboard
            ['name' => 'view dashboard'],
        ];

        $insert_data = [];
        $time_stamp = Carbon::now()->toDateTimeString();
        foreach ($data as $d) {
            $d['guard_name'] = 'webmaster';
            $d['created_at'] = $time_stamp;
            $insert_data[] = $d;
        }
        Permission::insert($insert_data);
    }
}
