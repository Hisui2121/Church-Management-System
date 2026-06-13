<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuditLogIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('view_audit_logs') === true;
    }

    public function rules(): array
    {
        return [
            'action' => ['nullable', 'array'],
            'action.*' => ['string', 'max:50'],
            'table_name' => ['nullable', 'array'],
            'table_name.*' => ['string', 'max:80'],
            'search' => ['nullable', 'string', 'max:100'],
        ];
    }
}
