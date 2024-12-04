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
        Schema::create('supervisas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guardaparque_id');
            $table->unsignedBigInteger('comunidad_id');
            //2 foraneas
            $table->foreign('guardaparque_id')->references('id')->on('guardaparques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisas');
    }
};
