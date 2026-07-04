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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('cita_id')->nullable()->constrained('citas')->onDelete('set null');
            
            $table->decimal('monto', 10, 2);
            // Methods: 'efectivo', 'tarjeta', 'transferencia', 'yape', 'plin', 'otro'
            $table->string('metodo_pago', 30); 
            $table->dateTime('fecha_pago')->index();
            
            // Statuses: 'pagado', 'pendiente', 'parcial', 'reembolsado'
            $table->string('estado', 20)->default('pendiente')->index();
            
            $table->text('notas')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
