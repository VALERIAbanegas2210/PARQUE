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
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['formulario_id']);

            // Agregar la clave foránea con la opción "on delete cascade"
            $table->foreign('formulario_id')
                ->references('id')
                ->on('formularios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar la clave foránea con "on delete cascade"
            $table->dropForeign(['formulario_id']);

            // Agregar la clave foránea sin la opción "on delete cascade"
            $table->foreign('formulario_id')
                ->references('id')
                ->on('formularios')
                ->onUpdate('cascade');
        });
    }
};
