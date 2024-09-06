<?php

namespace App\Models;

use App\Entities\AccountingAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAccount extends Model
{
    use HasFactory;

    public function member() {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function staff() {
        return $this->hasOne(StaffMember::class, 'id', 'staff_id');
    }

    public function accounting_accounts(){
        return $this->hasOne(AccountingAccount::class,'name','account_no');
    }

    public function accounttype() {
        return $this->hasOne(AccountType::class, 'id', 'accounttype_id');
    }
}
