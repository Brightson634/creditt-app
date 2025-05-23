<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeposit extends Model
{
    use HasFactory,BelongsToTenant;

    public function account() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
    public function memberAccount() {
        return $this->hasOne(MemberAccount::class, 'id', 'account_id');
    }

    public function paymenttype() {
        return $this->hasOne(PaymentType::class, 'id', 'paymenttype_id');
    }
}
