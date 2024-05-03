<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffMember extends Authenticatable
{
   use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $guard_name = 'Webmaster';
   protected $fillable = [
        'fname',
        'lname',
        'email',
        'email_verify_token',
        'telephone',
        'status',
        'role_id',
        'photo' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function branchposition() {
        return $this->hasOne(BranchPosition::class, 'id', 'branchposition_id');
    }
}