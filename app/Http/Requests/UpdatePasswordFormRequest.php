<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordFormRequest extends FormRequest
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
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    // custom messages
    public function messages(): array
    {
        return [
            'old_password.required' => 'A senha antiga é obrigatória',
            'old_password.min' => 'A senha antiga deve ter no mínimo 6 caracteres',
            'password.required' => 'A nova senha é obrigatória',
            'password.min' => 'A nova senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não coincidem',
        ];
    }
}
