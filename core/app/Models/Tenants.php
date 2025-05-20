<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    use HasFactory;

    // public $timestamps = false;
    public function tenantPackages()
    {
        return $this->hasMany(TenantPackage::class, 'tenant_id');
    }

    public function activePackage()
    {
        return $this->tenantPackages()->where('status',1)->first();
    }
    
}
