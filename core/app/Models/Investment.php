<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    public function member() {
        return $this->hasOne(Member::class, 'id', 'investor_id');
    }

    public function investor() {
        return $this->hasOne(Investor::class, 'id', 'investor_id');
    }

    public function investmentplan() {
        return $this->hasOne(InvestmentPlan::class, 'id', 'investmentplan_id');
    }
}
