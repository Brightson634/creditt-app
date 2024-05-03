<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function member() {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function staff() {
        return $this->hasOne(StaffMember::class, 'id', 'staff_id');
    }

    public function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function loanproduct() {
        return $this->hasOne(LoanProduct::class, 'id', 'loanproduct_id');
    }
}
