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
        Schema::create('recycling_stores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('telefono')->nullable();
            $table->string('web')->nullable();
            $table->string('ruta')->nullable();
            $table->string('empresa')->nullable();
            $table->string('alerta')->default('No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recycling_stores');
    }
};
