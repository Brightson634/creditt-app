<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'paymenttype_id',
        'amount',
        'withdrawer',
        'date',
        'description'
    ];

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
