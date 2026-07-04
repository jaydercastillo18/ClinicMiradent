<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoRequest;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagosController extends Controller
{


    /**
     * Store a newly created payment in storage.
     */
    public function store(PagoRequest $request)
    {
        $pago = Pago::create($request->validated());

        return $this->savedResponse(
            $request,
            'pagos.index',
            'Pago registrado correctamente en el sistema.',
            ['pago' => $this->formatearPago($pago->load(['paciente:id,nombre,apellido,dni,telefono', 'cita.servicio:id,nombre,precio']))],
            201
        );
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(PagoRequest $request, int $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->update($request->validated());

        return $this->savedResponse(
            $request,
            'pagos.index',
            'El pago ha sido actualizado correctamente.',
            ['pago' => $this->formatearPago($pago->fresh()->load(['paciente:id,nombre,apellido,dni,telefono', 'cita.servicio:id,nombre,precio']))]
        );
    }

    /**
     * Remove the specified payment from storage (soft delete).
     */
    public function destroy(Request $request, int $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return $this->deletedResponse($request, 'pagos.index', 'Pago anulado y eliminado del historial activo.');
    }

    private function formatearPago(Pago $pago): array
    {
        return [
            'id' => $pago->id,
            'paciente_id' => $pago->paciente_id,
            'paciente_nombre' => trim(($pago->paciente?->nombre ?? '') . ' ' . ($pago->paciente?->apellido ?? '')),
            'paciente_dni' => $pago->paciente?->dni,
            'paciente_telefono' => $pago->paciente?->telefono,
            'cita_id' => $pago->cita_id,
            'cita_fecha' => $pago->cita?->fecha_hora?->format('d/m/Y H:i'),
            'servicio_nombre' => $pago->cita?->servicio?->nombre,
            'monto' => $pago->monto,
            'monto_display' => 'S/. ' . number_format((float) $pago->monto, 2),
            'metodo_pago' => $pago->metodo_pago,
            'metodo_label' => $this->metodoLabel($pago->metodo_pago),
            'estado' => $pago->estado,
            'estado_label' => $this->estadoLabel($pago->estado),
            'fecha_pago' => $pago->fecha_pago?->format('Y-m-d'),
            'fecha_pago_display' => $pago->fecha_pago?->format('d/m/Y') ?? 'Sin fecha',
            'notas' => $pago->notas,
            'creado' => $pago->created_at?->format('d/m/Y H:i'),
        ];
    }

    private function metodoLabel(string $metodo): string
    {
        return [
            'efectivo' => 'Efectivo',
            'yape' => 'Yape',
            'plin' => 'Plin',
            'bcp' => 'BCP',
            'tarjeta' => 'Tarjeta',
            'transferencia' => 'Transferencia',
            'otro' => 'Otro',
        ][$metodo] ?? $metodo;
    }

    private function estadoLabel(string $estado): string
    {
        return [
            'pendiente' => 'Pendiente',
            'parcial' => 'Parcial',
            'pagado' => 'Pagado',
            'reembolsado' => 'Reembolsado',
        ][$estado] ?? $estado;
    }
}
