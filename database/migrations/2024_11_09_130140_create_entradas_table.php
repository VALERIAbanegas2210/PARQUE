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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();//nro de factura
            $table->string('nit');
            $table->string('codigoAutorizacion');
            $table->string('estado');
            $table->unsignedBigInteger('tipo_entrada_id');//llave de referencia para tipo de entrada
            /*$table->unsignedBigInteger('comunidad_id');
            
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade')->onUpdate('cascade');*/
            $table->foreign('tipo_entrada_id')->references('id')->on('tipo_entradas');//sin cascada
            $table->softDeletes(); // Esto crea la columna 'deleted_at'
            $table->date('fechaLimiteEmision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
