<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'yape_qr' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:15360'],
            'yape_phone' => ['nullable', 'string', 'max:20'],
        ];
    }
}
