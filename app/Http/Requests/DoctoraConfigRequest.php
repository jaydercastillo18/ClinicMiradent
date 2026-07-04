<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctoraConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'horario' => ['required', 'array'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ];
    }
}
