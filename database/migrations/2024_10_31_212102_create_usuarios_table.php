<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\MustVerifyEmail;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->string('pais')->nullable();
            $table->string('ciudad_nacimiento')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('rol', ['cliente', 'administrador'])->default('cliente');
            $table->timestamps();
        });

        // Comentar o eliminar este bloque para evitar duplicación de la tabla `sessions`
        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->foreignId('user_id')->nullable()->constrained('usuarios')->index();
        //     $table->string('ip_address', 45)->nullable();
        //     $table->text('user_agent')->nullable();
        //     $table->longText('payload');
        //     $table->integer('last_activity')->index();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabla `sessions` solo si fue creada en otra migración
        // Schema::dropIfExists('sessions');
        Schema::dropIfExists('usuarios'); // Cambiado a 'usuarios'
    }
};
