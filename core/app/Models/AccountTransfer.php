<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransfer extends Model
{
    use HasFactory;

    public function debitaccount() {
        return $this->hasOne(MemberAccount::class, 'id', 'debit_account');
    }
    // public function memberAccount() {
    //     return $this->hasOne(MemberAccount::class, 'id', 'account_id');
    // }

    public function creditaccount() {
        return $this->hasOne(MemberAccount::class, 'id', 'credit_account');
    }
}
