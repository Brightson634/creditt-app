<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    use HasFactory;
    
    public function staff() {
        return $this->hasOne(StaffMember::class, 'id', 'added_by');
    }
}
