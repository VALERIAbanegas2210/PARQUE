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
        Schema::create('guardaparques', function (Blueprint $table) {
            $table->id();
            $table->string('CI');
            $table->string('nombre');
            $table->integer('edad')->unsigned();
            $table->string('sexo')->nullable();
            $table->string('correo')->unique();
            $table->string('nroCelular')->nullable();
            $table->string('contraseña');

            $table->softDeletes(); // Esto crea la columna 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardaparques');
    }
};
