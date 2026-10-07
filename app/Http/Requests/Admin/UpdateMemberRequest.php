<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('id');

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $memberId,
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|string',
            'street' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city' => 'nullable|string',
            'member_status' => 'nullable|string',
            'member_type' => 'nullable|string',
            'baptism_status' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'ministry_interest' => 'nullable|string',
        ];
    }
}