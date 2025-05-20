<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageModule extends Model
{
    use HasFactory;
    protected $fillable = ['package_id', 'module_name', 'limits'];

    protected $casts = [
        'limits' => 'array', // Cast JSON to array
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
