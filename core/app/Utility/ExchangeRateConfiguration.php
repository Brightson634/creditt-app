<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRateConfiguration extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'exchange_rate',
        'department',
        'location',
        'exchange_rate_date',
        'business_id',
        'location_id',
    ];


    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }


    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }


    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }


    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }
}
