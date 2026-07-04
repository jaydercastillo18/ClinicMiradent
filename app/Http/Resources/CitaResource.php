<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isDoctora = $request->user()?->role === 'doctora';

        // We use a small helper for the label instead of duplicating logic from controller, 
        // or just return the raw estado and handle labels in the frontend.
        $estadoLabels = [
            'pendiente' => '<span class="badge bg-warning text-dark"><i data-lucide="clock" style="width: 12px; height: 12px;"></i> Pendiente</span>',
            'confirmada' => '<span class="badge bg-primary"><i data-lucide="calendar-check" style="width: 12px; height: 12px;"></i> Confirmada</span>',
            'completada' => '<span class="badge bg-success"><i data-lucide="check-circle" style="width: 12px; height: 12px;"></i> Completada</span>',
            'cancelada' => '<span class="badge bg-danger"><i data-lucide="x-circle" style="width: 12px; height: 12px;"></i> Cancelada</span>',
            'no_asistio' => '<span class="badge bg-secondary"><i data-lucide="user-x" style="width: 12px; height: 12px;"></i> No Asistió</span>',
        ];

        return [
            'id' => $this->id,
            'fecha_hora' => $this->fecha_hora?->format('Y-m-d\TH:i'),
            'fecha_display' => $this->fecha_hora?->format('d/m/Y H:i'),
            'servicio' => $this->servicio?->nombre,
            'doctora' => $this->doctora?->user?->name,
            'motivo' => $this->motivo,
            'estado' => $this->estado,
            'estado_label' => $estadoLabels[$this->estado] ?? '<span class="badge bg-light text-dark">Desconocido</span>',
            
            // Protected medical data
            'diagnostico' => $this->when($isDoctora, $this->diagnostico),
            'notas_tratamiento' => $this->when($isDoctora, $this->notas_tratamiento),
        ];
    }
}
