<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateGroupScheduleFormRequest extends FormRequest
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
            'group_id' => 'required|integer|exists:groups,id',
            'schedule_active' => 'required|boolean',
            'schedule_day' => 'required|integer|min:1|max:7',
            'schedule_start' => 'required|date_format:H:i',
            'schedule_end' => 'required|date_format:H:i',
            'schedule_id' => 'nullable|integer|exists:groups_schedules,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'group_id.exists' => 'Grupo não encontrado.',
            'schedule_day.min' => 'O dia da semana deve ser entre 1 e 7.',
            'schedule_day.max' => 'O dia da semana deve ser entre 1 e 7.',
            'schedule_day.required' => 'O dia da semana é obrigatório.',
            'schedule_start.required' => 'O horário de início é obrigatório.',
            'schedule_start.date_format' => 'O horário de início deve estar no formato HH:mm.',
            'schedule_end.required' => 'O horário de término é obrigatório.',
            'schedule_end.date_format' => 'O horário de término deve estar no formato HH:mm.',
            'schedule_id.exists' => 'Horário não encontrado.',
        ];
    }
}
