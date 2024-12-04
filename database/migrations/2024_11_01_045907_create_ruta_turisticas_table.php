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
        Schema::create('ruta_turisticas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('comunidad_id');
            
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade')->onUpdate('cascade');
            
            $table->string('disponibilidad');
            $table->softDeletes(); // Esto crea la columna 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruta_turisticas');
    }
};
