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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->enum('tipo', ['privada', 'compartida']);
            $table->integer('capacidad');
            $table->decimal('precio_noche', 10, 2);
            $table->decimal('prepago_noche', 10, 2);
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
