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
        Schema::create('valoracions', function (Blueprint $table) {
            $table->id();
            
            $table->tinyInteger('puntos');
            $table->text('comentario');
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade');
            $table->foreignId('deportista_id')->constrained('deportistas')->onDelete('cascade');
            $table->unique(['deportista_id', 'cancha_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracions');
    }
};
