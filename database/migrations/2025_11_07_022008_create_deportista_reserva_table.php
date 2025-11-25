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
        Schema::create('deportista_reserva', function (Blueprint $table) {
            $table->boolean('ingreso')->default(false);
            $table->string('qr_image')->nullable();
            $table->timestamp('fechaIngreso')->nullable();
            $table->foreignId('deportista_id')->constrained('deportistas')->onDelete('cascade');
            $table->foreignId('reserva_id')->constrained('reservas')->onDelete('cascade');
            $table->primary(['deportista_id', 'reserva_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deportista_reserva');
    }
};
