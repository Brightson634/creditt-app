<?php

namespace App\Models;

use App\Entities\AccountingAccount;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory, BelongsToTenant;
    
    public function account() {
        return $this->hasOne(AccountingAccount::class, 'id', 'account_id');
    }
}
