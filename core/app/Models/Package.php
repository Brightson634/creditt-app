<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'trial_days', 'sort_order', 'is_active'];

    public function modules()
    {
        return $this->hasMany(PackageModule::class);
    }

    public function tenants()
    {
        return $this->hasMany(TenantPackage::class);
    }
}
