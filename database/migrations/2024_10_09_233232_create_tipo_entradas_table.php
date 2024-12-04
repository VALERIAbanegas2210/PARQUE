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
        Schema::create('tipo_entradas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50)->unique();
            $table->float('precio');
            $table->string('descripcion');
            $table->softDeletes(); // Esto crea la columna 'deleted_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_entradas');
    }
};