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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->text('descripcion')->nullable();
            $table->decimal('monto', 10, 2);
            $table->string('categoria'); // Material, Equipamiento, Servicios, Personal, Otros
            $table->string('metodo_pago')->default('efectivo'); // efectivo, yape, plin, transferencia, tarjeta
            $table->date('fecha_gasto');
            $table->string('comprobante')->nullable(); // numero de boleta/factura
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
