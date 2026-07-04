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
        Schema::create('doctoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('especialidad');
            $table->string('COP', 20)->unique()->index(); // Colegiatura Médica del Perú
            $table->string('telefono', 20)->nullable();
            $table->text('bio')->nullable();
            $table->text('horario_atencion')->nullable(); // JSON o texto de horarios

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctoras');
    }
};
