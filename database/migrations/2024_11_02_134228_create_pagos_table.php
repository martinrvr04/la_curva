<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva')->nullable()->constrained('reservas')->onDelete('set null');
            $table->enum('metodo_pago', ['paypal', 'stripe', 'pse']);
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha')->useCurrent();
            $table->enum('estado', ['pendiente', 'completado', 'fallido'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};
