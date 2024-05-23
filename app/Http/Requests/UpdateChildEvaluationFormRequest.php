<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChildEvaluationFormRequest extends FormRequest
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
            'evaluation_id' => 'required|integer|exists:children_evaluations,id',
            'meeting_date' => 'nullable|date',
        ];

        // add positive qualities and negative qualities, get attributes from the model
        $emptyChildEval = new \App\Models\ChildEvaluation();

        $answersAttr = $emptyChildEval->getAnswersAttribute();
        foreach ($answersAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'nullable|string|max:3000';
        }

        $scaleAnswersAttr = $emptyChildEval->getScaleAnswerAttribute();
        foreach ($scaleAnswersAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'required|integer|min:0|max:10';
        }

        return $rules;
    }
}
