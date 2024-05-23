<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\TherapistEvaluation;
use App\Models\ChildEvaluation;
use App\Models\FamilyEvaluation;
use App\Models\Group;
use App\Models\FamilyMember;

use App\Http\Requests\CreateFamilyEvaluationFormRequest;


class FamilyEvaluationController extends Controller
{
    public $selectColumns = ['id', 'therapist_id', 'family_member_id', 'group_member_id', 'family_id', 'created_at', 'type', 'meeting_date'];

    public function index(Request $filters, $page = 1) : View
    {
        $family = auth()->user();

        $page = $filters->input('page') ?? 1;

        $therapistEvaluations = TherapistEvaluation::where('family_id', $family->id);
        $childEvaluations = ChildEvaluation::where('family_id', $family->id);
        $familyEvaluations = FamilyEvaluation::where('family_id', $family->id);

        if ($filters->has('search') && $filters->has('filterFamilyType') && $filters->input('search') != "" && $filters->input('filterFamilyType') != "") {
            if ($filters->has('filterFamilyType') && $filters->input('filterFamilyType') != "") {
                switch ($filters->input('filterFamilyType')) {
                    case 'memberDocument':
                        $therapistEvaluations = $therapistEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('document', 'like', '%'.$filters->input('search').'%');
                        });
                        $childEvaluations = $childEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('document', 'like', '%'.$filters->input('search').'%');
                        });
                        $familyEvaluations = $familyEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('document', 'like', '%'.$filters->input('search').'%');
                        });
                        break;
                    case 'memberName':
                        $therapistEvaluations = $therapistEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('name', 'like', '%'.$filters->input('search').'%');
                        });
                        $childEvaluations = $childEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('name', 'like', '%'.$filters->input('search').'%');
                        });
                        $familyEvaluations = $familyEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                            $query->where('name', 'like', '%'.$filters->input('search').'%');
                        });
                        break;
                }
            }
            else
            {
                $therapistEvaluations = $therapistEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                    $query->where('name', 'like', '%'.$filters->input('search').'%');
                });
                $childEvaluations = $childEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                    $query->where('name', 'like', '%'.$filters->input('search').'%');
                });
                $familyEvaluations = $familyEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                    $query->where('name', 'like', '%'.$filters->input('search').'%');
                });
            }
        }

        if ($filters->has('filterEvaluationType') && $filters->input('filterEvaluationType') != "" && $filters->input('filterEvaluationType') != "all") {
            switch ($filters->input('filterEvaluationType')) {
                case 'therapist':
                    $therapistEvaluations = $therapistEvaluations->where('type', 0);
                    $childEvaluations = $childEvaluations->where('type', 0);
                    $familyEvaluations = $familyEvaluations->where('type', 0);
                    break;
                case 'family':
                    $therapistEvaluations = $therapistEvaluations->where('type', 1);
                    $childEvaluations = $childEvaluations->where('type', 1);
                    $familyEvaluations = $familyEvaluations->where('type', 1);
                    break;
                case 'child':
                    $therapistEvaluations = $therapistEvaluations->where('type', 2);
                    $childEvaluations = $childEvaluations->where('type', 2);
                    $familyEvaluations = $familyEvaluations->where('type', 2);
                    break;
            }
        }

        $evaluations = $therapistEvaluations->select($this->selectColumns)->union($childEvaluations->select($this->selectColumns))->union($familyEvaluations->select($this->selectColumns));
        $evaluations = $evaluations->orderBy('meeting_date', 'desc')->paginate(10, ['*'], 'page', $page);

        $groups = Group::all();

        return view('families.evaluations.index', compact('evaluations', 'groups'));
    }

    public function create(Request $request)
    {
        if (!$request->has('family_member_id') || !is_numeric($request->family_member_id)) {
            return redirect()->route('families.evaluations');
        }

        $family = auth()->user();
        $evalType = 'family';
        $familyMember = FamilyMember::where('id', $request->family_member_id)->where('family_id', $family->id)->first();
        if ($familyMember) {
            return view('families.evaluations.family', compact('familyMember', 'evalType'));
        }

        return redirect()->route('families.evaluations');
    }

    public function view($id, $evalType)
    {
        $family = auth()->user();

        if (!in_array($evalType, ['therapist', 'child', 'family'])) {
            return redirect()->route('families.evaluations');
        }

        if ($evalType == 'therapist') {
            $evaluation = TherapistEvaluation::find($id);
        } elseif ($evalType == 'child') {
            $evaluation = ChildEvaluation::find($id);
        } elseif ($evalType == 'family') {
            $evaluation = FamilyEvaluation::find($id);
        } else {
            return redirect()->route('admin.evaluations');
        }

        if ($evaluation->family_id != $family->id) {
            return redirect()->route('admin.evaluations');
        }

        $familyMember = $evaluation->familyMember;

        if ($evaluation->type == 0) {
            return view('families.evaluations.therapist', compact('familyMember', 'evalType', 'evaluation'));
        } elseif ($evaluation->type == 1) {
            return view('families.evaluations.family', compact('familyMember', 'evalType', 'evaluation'));
        } elseif ($evaluation->type == 2) {
            return view('families.evaluations.child', compact('familyMember', 'evalType', 'evaluation'));
        }


        return redirect()->route('families.evaluations');
    }

    public function storeFamily(CreateFamilyEvaluationFormRequest $request)
    {
        $family = auth()->user();

        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            if ($familyMember->family_id != $family->id) {
                return redirect()->route('families.evaluations');
            }

            $evaluation = new FamilyEvaluation();
            $evaluation->therapist_id = $familyMember->therapist_id;
            $evaluation->family_member_id = $familyMember->id;
            $evaluation->family_id = $familyMember->family_id;
            $evaluation->group_member_id = $familyMember->groupMember->id;
            $evaluation->meeting_date = now();

            // Emotions
            foreach ($evaluation->getEmotionsAttributes() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
            }
            // Scale Answers
            foreach ($evaluation->getScaleAnswersAttributes() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->$attributeKey;
            }
            // Child Qualities
            foreach ($evaluation->getChildQualitiesAttributes() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
            }

            $evaluation->save();

            return redirect()->route('families.evaluations.view', ['id' => $evaluation->id, 'evalType' => 'family']);
        }

        return redirect()->route('families.evaluations');
    }
}
