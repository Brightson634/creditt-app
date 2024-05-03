<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransfer extends Model
{
    use HasFactory;

    public function debitaccount() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'debit_account');
    }

    public function creditaccount() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'credit_account');
    }
}
