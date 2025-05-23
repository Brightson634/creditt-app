<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRange extends Model
{
    use HasFactory,BelongsToTenant;

    public function fee() {
        return $this->hasOne(Fee::class, 'id', 'fee_id');
    }
}
