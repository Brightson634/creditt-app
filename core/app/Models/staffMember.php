<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Branch;
use App\Models\BranchPosition;

class staffMember extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'email_verify_token',
        'telephone',
        'status',
        'role_id',
        'photo' ,
        'google2fa_secret',
        'two_factor_enabled',
        'otp', 
        'otp_expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the role associated with the staff member.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function branchposition() {
        return $this->hasOne(BranchPosition::class, 'id', 'branchposition_id');
    }
}