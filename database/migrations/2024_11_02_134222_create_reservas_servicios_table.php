<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reservas_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva')->constrained('reservas')->onDelete('cascade');
            $table->foreignId('servicio')->constrained('servicios_adicionales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas_servicios');
    }
};