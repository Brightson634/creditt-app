<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationStoreItem extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'product_id',
        'variation_id',
        'stock_available',
        'is_product',
        'unit_id',
        'store_id'
    ];

    public function unit()
    {
        return $this->belongsTo(\App\Unit::class, 'unit_id');
    }

    public function product(){

        return $this->belongsTo(Product::class, 'product_id');
    }

    public function store(){

        return $this->belongsTo(LocationStore::class , 'store_id');
    }
}
