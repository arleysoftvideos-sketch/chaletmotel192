<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclingStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'web',
        'ruta',
        'empresa',
        'alerta',
    ];
}
