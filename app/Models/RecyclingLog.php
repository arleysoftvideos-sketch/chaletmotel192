<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'store',
        'big',
        'small',
        'total',
    ];
}
