<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_date' => 'required|date_format:Y-m-d\TH:i',
            'pastor_id' => 'nullable|exists:users,id',
            'pastor_name' => 'nullable|string|max:255',
            'service_title' => 'required|string|max:255',
            'verse' => 'nullable|string|max:255',
        ];
    }
}