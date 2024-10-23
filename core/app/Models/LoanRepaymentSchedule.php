<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepaymentSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_id',
        'member_id',
        'loan_officers',
        'due_date',
        'amount_due'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
