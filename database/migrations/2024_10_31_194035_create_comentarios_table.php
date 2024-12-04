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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->String('descripcion');
            $table->integer('puntuacion');
            //llave foranea de comunida
            $table->unsignedBigInteger('comunidad_id');
            //llave foranea de usuario
            $table->unsignedBigInteger('usuario_id');
            //le enlazo la cascada
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade')->onUpdate('cascade');
            //  le enlazo la cascada
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
