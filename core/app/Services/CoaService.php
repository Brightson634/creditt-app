<?php
namespace App\Services;

use App\Entities\AccountingAccount;

class CoaService {
     /**
    * Returns all charts of accounts for a given branch
    *
    * @return void
    */
    public static function getAllChartOfAccounts()
    {
       $business_id = request()->attributes->get('business_id');
       $accounts = AccountingAccount::forDropdown($business_id, true);
       // return new JsonResponse($accounts);
       // return $accounts;
       $translations = [
           "accounting::lang.accounts_payable" => "Accounts Payable",
           "accounting::lang.accounts_receivable" => "Accounts Receivable (AR)",
           "accounting::lang.credit_card" => "Credit Card",
           "accounting::lang.current_assets" => "Current Assets",
           "accounting::lang.cash_and_cash_equivalents" => "Cash and Cash Equivalents",
           "accounting::lang.fixed_assets" => "Fixed Assets",
           "accounting::lang.non_current_assets" => "Non Current Assets",
           "accounting::lang.cost_of_sale" => "Cost of Sale",
           "accounting::lang.expenses" => "Expenses",
           "accounting::lang.other_expense" => "Other Expense",
           "accounting::lang.income" => "Income",
           "accounting::lang.other_income" => "Other Income",
           "accounting::lang.owners_equity" => "Owner Equity",
           "accounting::lang.current_liabilities" => "Current Liabilities",
           "accounting::lang.non_current_liabilities" => "Non-Current Liabilities",
       ];
 
       $accounts_array = [];
       foreach ($accounts as $account) {
           $translatedText = $translations[$account->sub_type] ?? $account->sub_type;
           $accounts_array[] = [
               'id' => $account->id,
               'name'=>$account->name,
               'primaryType'=>$account->account_primary_type,
               'subType'=>$translatedText ,
               'currency' =>$account->account_currency
           ];
       }
 
       return $accounts_array;
    }
}
