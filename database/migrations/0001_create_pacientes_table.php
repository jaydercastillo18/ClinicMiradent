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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni', 20)->unique()->index();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable()->index();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('genero', 20)->nullable();
            $table->string('tipo_sangre', 5)->nullable();
            $table->text('direccion')->nullable();
            
            // Medical Information
            $table->text('antecedentes_medicos')->nullable();
            $table->text('alergias')->nullable();
            $table->text('medicamentos_habituales')->nullable();
            
            // Emergency Contact
            $table->string('contacto_emergencia_nombre')->nullable();
            $table->string('contacto_emergencia_telefono', 20)->nullable();
            $table->string('contacto_emergencia_parentesco', 50)->nullable();
            
            // Scalability & Soft Delete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
