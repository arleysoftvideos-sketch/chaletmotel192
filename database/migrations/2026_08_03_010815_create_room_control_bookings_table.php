<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_control_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('room');
            $table->string('cliente');
            $table->string('telefono')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_salida');
            $table->decimal('tasa_aseo', 10, 2)->default(0);
            $table->decimal('deposito', 10, 2)->default(0);
            $table->decimal('total_pagado', 10, 2)->default(0);
            $table->string('estado')->default('ABIERTO');
            $table->text('notas')->nullable();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_control_bookings');
    }
};
