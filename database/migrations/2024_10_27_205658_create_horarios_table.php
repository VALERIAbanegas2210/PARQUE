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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            ///horario 2 foraneas
            $table->unsignedBigInteger('dia_id'); // Relación con dia
            $table->foreign('dia_id')->references('id')->on('dias')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('supervisa_id');
            $table->foreign('supervisa_id')->references('id')->on('supervisas')->onDelete('cascade')->onUpdate('cascade');
            
            // Campos de hora de inicio y hora de fin
            $table->time('hora_inicio');
            $table->time('hora_fin');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
