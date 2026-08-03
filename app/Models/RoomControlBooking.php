<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomControlBooking extends Model
{
    use HasFactory;

    protected $table = 'room_control_bookings';

    protected $fillable = [
        'room',
        'cliente',
        'telefono',
        'fecha_inicio',
        'fecha_salida',
        'tasa_aseo',
        'deposito',
        'total_pagado',
        'estado',
        'notas',
        'fecha_registro',
    ];

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_salida' => 'date:Y-m-d',
        'tasa_aseo' => 'decimal:2',
        'deposito' => 'decimal:2',
        'total_pagado' => 'decimal:2',
    ];
}
