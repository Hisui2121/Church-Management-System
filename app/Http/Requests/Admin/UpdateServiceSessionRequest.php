<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_date' => 'required|date_format:Y-m-d H:i',
            'pastor_id' => 'nullable|exists:users,id',
            'service_title' => 'required|string|max:255',
            'verse' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }
}