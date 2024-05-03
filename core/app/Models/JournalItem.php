<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'account_id',
        'debit_amount',
        'credit_amount',
        'created_at',
        'updated_at',
    ];


    public function account() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
}
