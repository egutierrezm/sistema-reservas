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
        Schema::create('espacio_deportivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('direccion');
            $table->text('descripcion');
            $table->time('horaApertura');
            $table->time('horaCierre');
            $table->foreignId('administrador_espacio_id')->nullable()->constrained('administrador_espacios')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacio_deportivos');
    }
};
