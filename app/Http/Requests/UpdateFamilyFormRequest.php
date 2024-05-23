<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyFormRequest extends FormRequest
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
            'responsable_name' => 'required|string|max:255',
            'responsable_document' => 'required|string|max:14',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'familyImage' => 'nullable|file|mimes:png,jpeg,jpg|max:2048',
            'active' => 'required|boolean',
        ];
    }
}
