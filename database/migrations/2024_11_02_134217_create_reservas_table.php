<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->foreignId('habitacion')->nullable()->constrained('habitaciones')->onDelete('set null');
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->integer('num_adultos');
            $table->integer('num_niños')->default(0);
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $table->string('nombre'); // Nuevo campo
            $table->string('dni');    // Nuevo campo
            $table->string('email');  // Nuevo campo
            $table->timestamp('creado_en')->useCurrent();
            $table->decimal('precio_habitacion', 10, 2);
            $table->decimal('precio_total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
