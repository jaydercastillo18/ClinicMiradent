<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'dni' => [
                'required',
                'string',
                'max:12',
                Rule::unique('pacientes', 'dni')->ignore($this->route('id')),
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'genero' => ['nullable', 'string', 'max:20'],
            'tipo_sangre' => ['nullable', 'string', 'max:10'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'antecedentes_medicos' => ['nullable', 'string', 'max:4000'],
            'alergias' => ['nullable', 'string', 'max:1000'],
            'medicamentos_habituales' => ['nullable', 'string', 'max:1000'],
            'contacto_emergencia_nombre' => ['nullable', 'string', 'max:255'],
            'contacto_emergencia_telefono' => ['nullable', 'string', 'max:20'],
            'contacto_emergencia_parentesco' => ['nullable', 'string', 'max:100'],
        ];
    }
}
