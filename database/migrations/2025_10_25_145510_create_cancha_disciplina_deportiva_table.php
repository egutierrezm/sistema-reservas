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
        Schema::create('cancha_disciplina_deportiva', function (Blueprint $table) {
            $table->foreignId('cancha_id')->references('id')->on('canchas')->onDelete('cascade');
            $table->foreignId('disciplina_deportiva_id')->references('id')->on('disciplina_deportivas')->onDelete('cascade');
            $table->primary(['cancha_id', 'disciplina_deportiva_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancha_disciplina_deportiva');
    }
};
