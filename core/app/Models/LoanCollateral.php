<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCollateral extends Model
{
    use HasFactory;

    public function item() {
        return $this->hasOne(CollateralItem::class, 'id', 'collateral_item_id');
    }
}
