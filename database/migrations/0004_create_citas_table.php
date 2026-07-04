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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('doctora_id')->constrained('doctoras')->onDelete('cascade');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('set null');
            
            $table->dateTime('fecha_hora')->index();
            $table->text('motivo')->nullable();
            
            // Medical treatment annotations during appointment
            $table->text('diagnostico')->nullable();
            $table->text('notas_tratamiento')->nullable();
            
            // Statuses: 'pendiente', 'en_espera', 'completada', 'cancelada'
            $table->string('estado', 20)->default('pendiente')->index();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
