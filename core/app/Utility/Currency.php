<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    public static function forDropdown()
    {
        return  Currency::all();

    }
}