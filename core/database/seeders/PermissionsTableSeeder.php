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
        $data = [
            // Loan Permissions
            ['name' => 'view_loans'],
            ['name' => 'view_own_loans'],
            ['name' => 'add_loans'],
            ['name' => 'edit_loans'],
            ['name' => 'delete_loans'],
            ['name' => 'review_loans'],
            ['name' => 'approve_loans'],
            ['name' => 'reject_loans'],
            ['name' => 'disburse_loans'],
            ['name' => 'add_loan_product'],
            ['name' => 'edit_loan_product'],
            ['name' => 'delete_loan_product'],
            ['name' => 'view_loan_products'],
            ['name' => 'add_loan_repayment'],
            ['name' => 'view_loan_repayments'],
            ['name' => 'edit_loan_repayment'],
            ['name' => 'delete_loan_repayment'],
            ['name' => 'view_loan_repayment_schedule'],
            ['name' => 'access_loan_calculator'],
            ['name' => 'view_loan_dashboard'],

            // Accounting Permissions
            ['name' => 'view_accounting_dashboard'],
            ['name' => 'view_accounting_charts_of_accounts'],
            ['name' => 'add_accounting_account'],
            ['name' => 'edit_accounting_account'],
            ['name' => 'delete_accounting_account'],
            ['name' => 'view_accounting_journal_entry'],
            ['name' => 'add_accounting_journal_entry'],
            ['name' => 'edit_accounting_journal_entry'],
            ['name' => 'delete_accounting_journal_entry'],
            ['name' => 'view_accounting_transfer'],
            ['name' => 'add_accounting_transfer'],
            ['name' => 'edit_accounting_transfer'],
            ['name' => 'delete_accounting_transfer'],
            ['name' => 'view_accounting_transactions'],
            ['name' => 'add_accounting_transactions'],
            ['name' => 'edit_accounting_transactions'],
            ['name' => 'delete_accounting_transactions'],
            ['name' => 'view_accounting_budgets'],
            ['name' => 'add_accounting_budgets'],
            ['name' => 'edit_accounting_budgets'],
            ['name' => 'delete_accounting_budgets'],
            ['name' => 'export_accounting_reports'],
            ['name' => 'reconcile_accounting_accounts'],
            ['name' => 'view_accounting_settings'],
            ['name' => 'add_accounting_detail_type'],
            ['name' => 'edit_accounting_detail_type'],
            ['name' => 'delete_accounting_detail_type'],
            ['name' => 'view_accounting_detail_type'],
            ['name' => 'add_accounting_account_sub_type'],
            ['name' => 'edit_accounting_account_sub_type'],
            ['name' => 'delete_accounting_account_sub_type'],
            ['name' => 'view_accounting_account_sub_type'],

            // Staff Permissions
            ['name' => 'view_staff'],
            ['name' => 'add_staff'],
            ['name' => 'edit_staff'],
            ['name' => 'delete_staff'],

            // Members Permissions
            ['name' => 'view_members'],
            ['name' => 'add_members'],
            ['name' => 'edit_members'],
            ['name' => 'delete_members'],
            ['name' => 'view_members_account_statement'],
            ['name' => 'add_members_account'],
            ['name' => 'edit_members_account'],
            ['name' => 'delete_members_account'],
            ['name' => 'view_members_dashboard'],
            ['name' => 'view_members_account'],

            // Roles Permissions
            ['name' => 'view_roles'],
            ['name' => 'create_roles'],
            ['name' => 'edit_roles'],
            ['name' => 'delete_roles'],
            ['name' => 'assign_roles'],

            // Reports Permissions
            ['name' => 'view_loan_reports'],
            ['name' => 'view_member_reports'],
            ['name' => 'view_investment_reports'],
            ['name' => 'view_savings_reports'],
            ['name' => 'view_accounting_reports'],
            ['name' => 'view_expense_reports'],
            ['name' => 'view_assets_reports'],
            ['name' => 'generate_reports'],
            ['name' => 'export_reports'],
            ['name' => 'delete_reports'],

            // Funds Manager Permissions
            ['name' => 'view_funds_deposits'],
            ['name' => 'view_funds_receipts'],
            ['name' => 'view_funds_details'],
            ['name' => 'view_funds_deposits'],
            ['name' => 'add_funds_deposits'],
            ['name' => 'edit_funds_deposits'],
            ['name' => 'delete_funds_deposits'],
            ['name' => 'view_funds_withdrawals'],
            ['name' => 'add_funds_withdrawals'],
            ['name' => 'edit_funds_withdrawals'],
            ['name' => 'delete_funds_withdrawals'],
            ['name' => 'view_funds_transfers'],
            ['name' => 'add_funds_transfers'],
            ['name' => 'edit_funds_transfers'],
            ['name' => 'delete_funds_transfers'],

            // Investments Permissions
            ['name' => 'view_investments'],
            ['name' => 'add_investments'],
            ['name' => 'edit_investments'],
            ['name' => 'delete_investments'],
            ['name' => 'view_investors'],
            ['name' => 'add_investors'],
            ['name' => 'edit_investors'],
            ['name' => 'view_investors_dashboard'],
            ['name' => 'delete_investors'],
            ['name' => 'view_investment_plan'],
            ['name' => 'add_investment_plan'],
            ['name' => 'edit_investment_plan'],
            ['name' => 'delete_investment_plan'],
            ['name' => 'view_shares'],
            ['name' => 'add_shares'],
            ['name' => 'edit_shares'],
            ['name' => 'delete_shares'],

            // Savings Permissions
            ['name' => 'view_savings'],
            ['name' => 'add_savings'],
            ['name' => 'edit_savings'],
            ['name' => 'delete_savings'],
            ['name' => 'view_staff_dashboard'],

            // Assets Permissions
            ['name' => 'view_assets'],
            ['name' => 'add_assets'],
            ['name' => 'edit_assets'],
            ['name' => 'delete_assets'],
            ['name' => 'view_assets_group'],
            ['name' => 'add_assets_group'],
            ['name' => 'edit_assets_group'],
            ['name' => 'delete_assets_group'],
            ['name' => 'view_assets_supplier'],
            ['name' => 'add_assets_supplier'],
            ['name' => 'edit_assets_supplier'],
            ['name' => 'delete_assets_supplier'],

            // Branches Permissions
            ['name' => 'view_branch'],
            ['name' => 'add_branch'],
            ['name' => 'edit_branch'],
            ['name' => 'delete_branch'],

            // Expenses Permissions
            ['name' => 'view_expenses'],
            ['name' => 'add_expenses'],
            ['name' => 'edit_expenses'],
            ['name' => 'delete_expenses'],
            ['name' => 'view_category'],
            ['name' => 'add_category'],
            ['name' => 'edit_category'],
            ['name' => 'delete_category'],

            // Settings Permissions
            ['name' => 'view_system_settings'],
            ['name' => 'update_system_settings'],
            ['name' => 'view_email_settings'],
            ['name' => 'update_email_settings'],
            ['name' => 'view_logo_settings'],
            ['name' => 'update_logo_settings'],
            ['name' => 'view_prefix_settings'],
            ['name' => 'add_prefix_settings'],
            ['name' => 'edit_prefix_settings'],
            ['name' => 'delete_prefix_settings'],
            ['name' => 'view_loan_settings'],
            ['name' => 'add_loan_settings'],
            ['name' => 'edit_loan_settings'],
            ['name' => 'delete_loan_settings'],
            ['name' => 'view_account_types_settings'],
            ['name' => 'add_account_types_settings'],
            ['name' => 'edit_account_types_settings'],
            ['name' => 'delete_account_types_settings'],
            ['name' => 'view_collateral_settings'],
            ['name' => 'add_collateral_settings'],
            ['name' => 'edit_collateral_settings'],
            ['name' => 'delete_collateral_settings'],
            ['name' => 'view_role_settings'],
            ['name' => 'add_role_settings'],
            ['name' => 'edit_role_settings'],
            ['name' => 'delete_role_settings'],
            ['name' => 'view_fee_settings'],
            ['name' => 'add_fee_settings'],
            ['name' => 'edit_fee_settings'],
            ['name' => 'delete_fee_settings'],
            ['name' => 'view_exchange_rates_settings'],
            ['name' => 'add_exchange_rates_settings'],
            ['name' => 'edit_exchange_rates_settings'],
            ['name' => 'delete_exchange_rates_settings'],
            ['name' => 'generate_system_backup'],

            // Dashboard Permissions
            ['name' => 'view_main_dashboard'],
            ['name' => 'view_loan_overview_on_dashboard'],
            ['name' => 'view_recent_transactions_on_dashboard'],
            ['name' => 'view_savings_overview_on_dashboard'],
            ['name' => 'view_statistics_overview_on_dashboard'],
            ['name' => 'view_revenues_overview_on_dashboard'],
            ['name' => 'view_expenses_overview_on_dashboard'],
        ];

        foreach ($data as $d) {
            // Categorizing permissions using the getModule function
            $moduleInfo = getModule($d['name']);
            if ($moduleInfo) {
                // Assign guard_name
                Permission::firstOrCreate(
                    ['name' => $d['name']], 
                    ['guard_name' => 'webmaster']
                );
            }
        }
    }
    
}
