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
        Schema::create('bitacora__guardaparques', function (Blueprint $table) {
            //$table->timestamps();
            $table->id();
            $table->unsignedBigInteger('id_comunidad');
            $table->unsignedBigInteger('id_guardaparque');
            $table->string('nombreComunidad');
            $table->string('nombreGuardaparque');
            $table->dateTime('fecha');
            $table->char('tipo', 1);
            //$table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora__guardaparques');
    }
};
