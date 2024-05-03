<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    public function parentaccount() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'parent_id');
    }

    public function accounttype() {
        return $this->hasOne(ChartOfAccountType::class, 'id', 'accounttype_id');
    }

    public function accountsubtype() {
        return $this->hasOne(ChartOfAccountType::class, 'id', 'accountsubtype_id');
    }
 
    public function currency() {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function paymenttype() {
        return $this->hasOne(PaymentType::class, 'id', 'paymenttype_id');
    }
}
