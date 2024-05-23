<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyEvaluationFormRequest extends FormRequest
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
            'evaluation_id' => 'required|integer|exists:families_evaluations,id',
            'meeting_date' => 'nullable|date',
        ];

        // add positive qualities and negative qualities, get attributes from the model
        $emptyFamilyEval = new \App\Models\FamilyEvaluation();

        $emotionsAttr = $emptyFamilyEval->getEmotionsAttributes();
        foreach ($emotionsAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'nullable|boolean';
        }

        $scaleAnswersAttr = $emptyFamilyEval->getScaleAnswersAttributes();
        foreach ($scaleAnswersAttr as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'required|integer|min:0|max:10';
        }

        $childQualities = $emptyFamilyEval->getChildQualitiesAttributes();
        foreach ($childQualities as $attrKey => $attrMsg) {
            $rules[$attrKey] = 'nullable|boolean';
        }

        return $rules;
    }
}
