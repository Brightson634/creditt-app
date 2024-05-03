<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    public function member() {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function account() {
        return $this->hasOne(MemberAccount::class, 'id', 'account_id');
    }
}
