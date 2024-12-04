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
        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->string('ci');//es nullable
            $table->string('nombre');
            $table->integer('edad');
            //$table->string('sexo'); ya no se usara
            $table->string('pasaporte')->nullable();
            $table->tinyInteger('tiempoEstadia');
            $table->dateTime('fechaIngreso')->nullable();
            $table->dateTime('fechaSalida')->nullable();
            $table->dateTime('fechaReserva')->nullable();
            $table->string('estado')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('estadoUsuario')->nullable();

            $table->unsignedBigInteger('departamento_id')->nullable();
            //$table->unsignedBigInteger('formulario_id')->nullable();
            $table->unsignedBigInteger('ruta_turistica_id');
            $table->unsignedBigInteger('reserva_id');
            $table->unsignedBigInteger('tipo_entrada_id');
            $table->unsignedBigInteger('comunidad_id');
            $table->unsignedBigInteger('entrada_id')->nullable();//ojo al tejo

            $table->unsignedBigInteger('guardaparque_id')->nullable();
            
            //acordarme de eliminar los update de las cascadas

            $table->foreign('departamento_id')->references('id')->on('departamentos'); //->onUpdate('cascade');
            //$table->foreign('tipo_pago_id')->references('id')->on('tipo_pagos')->onUpdate('cascade');
            $table->foreign('ruta_turistica_id')->references('id')->on('ruta_turisticas');//->onUpdate('cascade');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('guardaparque_id')->references('id')->on('guardaparques');//->onUpdate('cascade');
            $table->foreign('tipo_entrada_id')->references('id')->on('tipo_entradas');//->onUpdate('cascade');
            $table->foreign('comunidad_id')->references('id')->on('comunidads');//->onUpdate('cascade');
            $table->foreign('entrada_id')->references('id')->on('entradas');//->onUpdate('cascade');

            //$table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
