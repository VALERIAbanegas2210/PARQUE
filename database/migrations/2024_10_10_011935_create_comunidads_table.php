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
        Schema::create('comunidads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50)->unique();
            $table->text('descripcion');
            $table->string('zona');
            $table->string('disponibilidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunidads');
    }
};