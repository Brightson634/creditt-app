<?php

namespace App\Models;

use App\Models\Branch;
use App\Scopes\TenantScope;
use App\Models\BranchPosition;
use App\Traits\BelongsToTenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffMember extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, BelongsToTenant;

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
        'otp_expires_at',
        'two_factor_type',
        'tenant_id',
        'title',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope(new TenantScope);

    //     static::creating(function ($model) {
    //         if (app()->bound('tenant') && empty($model->tenant_id)) {
    //             $model->tenant_id = app('tenant')->id;
    //         }
    //     });
    // }


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
    public function tenant()
    {
        return $this->belongsTo(Tenants::class, 'tenant_id');
    }
}