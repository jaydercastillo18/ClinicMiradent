<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_paciente' => 'required|string|max:255',
            'testimonio' => 'required|string|max:1000',
            'fecha' => 'required|date',
            'estrellas' => 'required|integer|min:1|max:5',
            'activo' => 'required|boolean',
        ];
    }
}
