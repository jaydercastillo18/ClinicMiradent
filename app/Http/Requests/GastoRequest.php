<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GastoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'concepto' => ['required', 'string', 'max:255'],
            'monto' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'categoria' => ['required', 'string', 'max:100'],
            'metodo_pago' => ['required', 'string', 'max:50'],
            'fecha_gasto' => ['required', 'date'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'comprobante' => ['nullable', 'string', 'max:100'],
        ];
    }
}
