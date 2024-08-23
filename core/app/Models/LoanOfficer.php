<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
class LoanOfficer extends Model
{
    use HasFactory;

    public function getAccessAttribute($value)
    {
        return json_decode($value, true);
    }

    public function staff() {
        return $this->hasOne(StaffMember::class, 'id', 'staff_id');
    }

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
