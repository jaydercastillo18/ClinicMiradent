<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isDoctora = $request->user()?->role === 'doctora';

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nombre_completo' => trim($this->nombre . ' ' . $this->apellido),
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'fecha_nacimiento' => $this->fecha_nacimiento?->format('Y-m-d'),
            'edad' => $this->fecha_nacimiento?->age,
            'genero' => $this->genero,
            'tipo_sangre' => $this->tipo_sangre,
            'direccion' => $this->direccion,
            'creado' => $this->created_at?->format('d/m/Y H:i'),
            
            // Protected medical data
            'antecedentes_medicos' => $this->when($isDoctora, $this->antecedentes_medicos),
            'alergias' => $this->when($isDoctora, $this->alergias),
            'medicamentos_habituales' => $this->when($isDoctora, $this->medicamentos_habituales),
            'contacto_emergencia_nombre' => $this->when($isDoctora, $this->contacto_emergencia_nombre),
            'contacto_emergencia_telefono' => $this->when($isDoctora, $this->contacto_emergencia_telefono),
            'contacto_emergencia_parentesco' => $this->when($isDoctora, $this->contacto_emergencia_parentesco),
        ];
    }
}
