<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTherapistEvaluationFormRequest extends FormRequest
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
        $rules = [
            'evaluation_id' => 'required|integer|exists:therapists_evaluations,id',
            'meeting_date' => 'nullable|date',

            'child_presence' => 'required|integer',
        ];

        // add positive qualities and negative qualities, get attributes from the model
        $emptyTherapistEval = new \App\Models\TherapistEvaluation();
        $positiveAttr = $emptyTherapistEval->getPositiveQualitiesAttributes();
        $negativeAttr = $emptyTherapistEval->getNegativeQualitiesAttributes();

        foreach ($positiveAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'nullable|boolean';
        }
        foreach ($negativeAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'nullable|boolean';
        }

        return $rules;
    }
}
