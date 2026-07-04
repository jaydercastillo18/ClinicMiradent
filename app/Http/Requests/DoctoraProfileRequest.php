<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DoctoraProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctoraId = Auth::user()->doctora?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())],
            'especialidad' => ['required', 'string', 'max:255'],
            'COP' => ['required', 'string', 'max:20', Rule::unique('doctoras', 'COP')->ignore($doctoraId)],
            'telefono' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:15360'],
        ];
    }
}
