<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCharge extends Model
{
    use HasFactory,BelongsToTenant;

    public function account() {
        return $this->hasOne(MemberAccount::class, 'id', 'account_id');
    }
}
