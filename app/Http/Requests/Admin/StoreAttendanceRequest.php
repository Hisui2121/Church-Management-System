<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Admin') === true;
    }

    public function rules(): array
    {
        return [
            'member_id' => [
                'required',
                'integer',
                'exists:members,id',
                Rule::unique('attendances')->where(fn ($query) => $query
                    ->where('member_id', $this->input('member_id'))
                    ->where('date', $this->input('date'))),
            ],
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'date' => ['required', 'date'],
            'status' => ['required', Rule::in(['Present', 'Absent'])],
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.unique' => 'This member already has an attendance record for the selected date.',
        ];
    }
}
