<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table): void {
            $table->index('created_at', 'pacientes_created_at_idx');
            $table->index(['nombre', 'apellido'], 'pacientes_nombre_apellido_idx');
            $table->index('telefono', 'pacientes_telefono_idx');
        });

        Schema::table('servicios', function (Blueprint $table): void {
            $table->index(['activo', 'categoria'], 'servicios_activo_categoria_idx');
        });

        Schema::table('citas', function (Blueprint $table): void {
            $table->index(['fecha_hora', 'estado'], 'citas_fecha_estado_idx');
            $table->index(['paciente_id', 'fecha_hora'], 'citas_paciente_fecha_idx');
            $table->index(['servicio_id', 'fecha_hora'], 'citas_servicio_fecha_idx');
        });

        Schema::table('pagos', function (Blueprint $table): void {
            $table->index(['fecha_pago', 'estado'], 'pagos_fecha_estado_idx');
            $table->index(['paciente_id', 'fecha_pago'], 'pagos_paciente_fecha_idx');
            $table->index('metodo_pago', 'pagos_metodo_pago_idx');
        });

        Schema::table('gastos', function (Blueprint $table): void {
            $table->index(['fecha_gasto', 'categoria'], 'gastos_fecha_categoria_idx');
            $table->index('metodo_pago', 'gastos_metodo_pago_idx');
        });
    }

    public function down(): void
    {
        Schema::table('gastos', function (Blueprint $table): void {
            $table->dropIndex('gastos_fecha_categoria_idx');
            $table->dropIndex('gastos_metodo_pago_idx');
        });

        Schema::table('pagos', function (Blueprint $table): void {
            $table->dropIndex('pagos_fecha_estado_idx');
            $table->dropIndex('pagos_paciente_fecha_idx');
            $table->dropIndex('pagos_metodo_pago_idx');
        });

        Schema::table('citas', function (Blueprint $table): void {
            $table->dropIndex('citas_fecha_estado_idx');
            $table->dropIndex('citas_paciente_fecha_idx');
            $table->dropIndex('citas_servicio_fecha_idx');
        });

        Schema::table('servicios', function (Blueprint $table): void {
            $table->dropIndex('servicios_activo_categoria_idx');
        });

        Schema::table('pacientes', function (Blueprint $table): void {
            $table->dropIndex('pacientes_created_at_idx');
            $table->dropIndex('pacientes_nombre_apellido_idx');
            $table->dropIndex('pacientes_telefono_idx');
        });
    }
};
