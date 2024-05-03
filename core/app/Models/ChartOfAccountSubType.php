<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccountSubType extends Model
{
    use HasFactory;

    public function accounttype() {
        return $this->hasOne(ChartOfAccountType::class, 'id', 'accounttype_id');
    }
}
