<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRange extends Model
{
    use HasFactory;

    public function fee() {
        return $this->hasOne(Fee::class, 'id', 'fee_id');
    }
}
