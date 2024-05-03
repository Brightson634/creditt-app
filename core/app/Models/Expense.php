<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function category() {
        return $this->hasOne(ExpenseCategory::class, 'id', 'category_id');
    }

    public function subcategory() {
        return $this->hasOne(ExpenseCategory::class, 'id', 'subcategory_id');
    }

    public function account() {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
}
