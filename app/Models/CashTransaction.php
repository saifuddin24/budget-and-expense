<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class CashTransaction extends Transaction
{
    use HasFactory;

    public $casts = [
        'year_month' => 'date'
    ];
    
}
