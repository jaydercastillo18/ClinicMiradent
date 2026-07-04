<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => [
                'required',
                'integer',
                Rule::exists('pacientes', 'id')->whereNull('deleted_at'),
            ],
            'cita_id' => [
                'nullable',
                'integer',
                Rule::exists('citas', 'id')->whereNull('deleted_at'),
            ],
            'monto' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'metodo_pago' => ['required', Rule::in(['yape', 'plin', 'bcp', 'tarjeta', 'efectivo', 'transferencia', 'otro'])],
            'fecha_pago' => ['required', 'date'],
            'estado' => ['required', Rule::in(['pagado', 'parcial', 'pendiente', 'reembolsado'])],
            'notas' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
