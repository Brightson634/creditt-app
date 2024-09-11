<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;

    // Define the relationship with the AccountDeposit model
    public function deposit()
    {
        return $this->belongsTo(AccountDeposit::class, 'deposit_id');
    }

    // Define the relationship with the AccountWithdraw model
    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class, 'withdraw_id');
    }

    // Define the relationship with the AccountTransfer model
    public function transfer()
    {
        return $this->belongsTo(AccountTransfer::class, 'transfer_id');
    }
}
