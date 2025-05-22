<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory,BelongsToTenant;
    protected $fillable = ['from_currency_id', 'to_currency_id', 'exchange_rate','branch_id','tenant_id'];
}
