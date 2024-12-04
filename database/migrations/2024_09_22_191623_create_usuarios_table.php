<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('usuario');
            $table->string('correo');
            $table->string('contraseña');
            $table->string('ci')->nullable();
            $table->integer('edad');
            $table->string('sexo');
            $table->string('pasaporte')->nullable();
            $table->string('nacionalidad');
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};