<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeposit extends Model
{
    use HasFactory;

    public function account() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }

    public function paymenttype() {
        return $this->hasOne(PaymentType::class, 'id', 'paymenttype_id');
    }
}
