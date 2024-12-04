<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relación con el usuario
            $table->string('action'); // Acción: login o logout
            $table->string('ip_address')->nullable(); // Dirección IP
            $table->timestamps();

            // Llave foránea
            //$table->unsignedBigInteger('user_id'); // Relación con el usuario
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};