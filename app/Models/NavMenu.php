<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavMenu extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'url',
        'active'
    ];
}
