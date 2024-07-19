<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'label',
        'business_id',
        'description',
        'location_id'
    ];
}
