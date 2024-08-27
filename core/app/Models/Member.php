<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;
    use Notifiable;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'member';
    protected $fillable = [
        'name',
        'email',
        'email_verify_token',
        'phone',
        'status',
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

    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function staff() {
        return $this->hasOne(StaffMember::class, 'id', 'staff_id');
    }
} 