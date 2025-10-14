<?php

namespace App\Entities;

use Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountingAccountsTransaction extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
    }

    /**
     * Creates new account transaction
     *
     * @return obj
     */
    public static function createTransaction($data)
    {
        $transaction = new AccountingAccountsTransaction();

        $transaction->amount = $data['amount'];
        $transaction->accounting_account_id = $data['accounting_account_id'];
        $transaction->transaction_id = ! empty($data['transaction_id']) ? $data['transaction_id'] : null;
        $transaction->type = $data['type'];
        $transaction->sub_type = ! empty($data['sub_type']) ? $data['sub_type'] : null;
        $transaction->map_type = ! empty($data['map_type']) ? $data['map_type'] : null;
        $transaction->operation_date = ! empty($data['operation_date']) ? $data['operation_date'] : \Carbon\Carbon::now();
        $transaction->created_by = $data['created_by'];
        $transaction->note = ! empty($data['note']) ? $data['note'] : null;

        return $transaction->save();
    }

   /**
 * Creates/updates account transaction
 *
 * @return AccountingAccountsTransaction
 */
public static function updateOrCreateMapTransaction($data)
{
    $type = $data['sub_type'] ?? null;

    $updateCond = [
        'type' => $data['type'] ?? null,
        'operation_date' => $data['operation_date'] ?? now(),
    ];

    // Add type-specific key
    if ($type === 'loan_payment') {
        $updateCond['loan_id'] = $data['loan_id'] ?? null;
    } elseif ($type === 'expense') {
        $updateCond['expense_id'] = $data['expense_id'] ?? null;
    } else {
        $updateCond['transaction_id'] = $data['transaction_id'] ?? null;
    }

    // Values to update or create
    $values = [
        'accounting_account_id' => $data['accounting_account_id'] ?? null,
        'amount' => $data['amount'] ?? 0,
        'loan_id' => $data['loan_id'] ?? null, 
        'type' => $data['type'] ?? null,
        'sub_type' => $type,
        'created_by' => $data['created_by'] ?? null,
        'operation_date' => $data['operation_date'] ?? now(),
        'note' => $data['note'] ?? null,
        'expense_id' => $data['expense_id'] ?? null,
    ];

    // Create or update transaction
    AccountingAccountsTransaction::updateOrCreate($updateCond, $values);
}

}