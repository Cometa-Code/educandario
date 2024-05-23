<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyMemberFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_name' => 'required|string|max:255',
            'member_document' => 'required|string|max:14',
            'member_birth_date' => 'required|date',
            'member_image' => 'nullable|file|mimes:png,jpeg,jpg|max:2048',
            'member_therapist_id' => 'required|integer|exists:users,id',
            'member_group_schedule' => 'required|integer|exists:groups_schedules,id',
        ];
    }
}
