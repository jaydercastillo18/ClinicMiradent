<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasoExitoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo_tratamiento' => 'required|string|max:255',
            'descripcion_resultado' => 'required|string|max:1000',
            'categoria' => 'required|string|max:255',
            'activo' => 'required|boolean',
            'antes' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'despues' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ];
    }
}
