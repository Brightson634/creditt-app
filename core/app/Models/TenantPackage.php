<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPackage extends Model
{
    use HasFactory;
    protected $fillable = ['tenant_id', 'package_id', 'start_date', 'end_date', 'is_trial','status'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenants::class);
    }
}
