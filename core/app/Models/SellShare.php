<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellShare extends Model
{
    use HasFactory;

    public function member() {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function share() {
        return $this->hasOne(Share::class, 'id', 'share_id');
    }
}
