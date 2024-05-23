<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FamilyMember;
use App\Models\Group;
use App\Models\TherapistEvaluation;
use App\Models\ChildEvaluation;
use App\Models\FamilyEvaluation;
use App\Http\Requests\CreateTherapistEvaluationFormRequest;
use App\Http\Requests\UpdateTherapistEvaluationFormRequest;
use App\Http\Requests\CreateFamilyEvaluationFormRequest;
use App\Http\Requests\UpdateFamilyEvaluationFormRequest;
use App\Http\Requests\CreateChildEvaluationFormRequest;
use App\Http\Requests\UpdateChildEvaluationFormRequest;


class AdminEvaluationController extends Controller
{
    public $selectColumns = ['id', 'therapist_id', 'family_member_id', 'group_member_id', 'family_id', 'created_at', 'type', 'meeting_date'];

    public function index(Request $filters, $page = 1) : View
    {

        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $page = $filters->input('page') ?? 1;

        $therapistEvaluations = $superAdmin ? new TherapistEvaluation() : TherapistEvaluation::ByTherapist($therapist->id);
        $childEvaluations = $superAdmin ? new ChildEvaluation() : ChildEvaluation::ByTherapist($therapist->id);
        $familyEvaluations = $superAdmin ? new FamilyEvaluation() : FamilyEvaluation::ByTherapist($therapist->id);

        if ($filters->has('search') && $filters->has('filterFamilyType') && $filters->input('search') != "" && $filters->input('filterFamilyType') != "") {
            if ($filters->has('filterFamilyType') && $filters->input('filterFamilyType') != "") {
                switch ($filters->input('filterFamilyType')) {
                    case 'resDocument':
                        $therapistEvaluations = $therapistEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_document', 'like', '%'.$filters->input('search').'%');
                        });
                        $childEvaluations = $childEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_document', 'like', '%'.$filters->input('search').'%');
                        });
                        $familyEvaluations = $familyEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_document', 'like', '%'.$filters->input('search').'%');
                        });
                        break;
                    case 'resName':
                        $therapistEvaluations = $therapistEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_name', 'like', '%'.$filters->input('search').'%');
                        });
                        $childEvaluations = $childEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_name', 'like', '%'.$filters->input('search').'%');
                        });
                        $familyEvaluations = $familyEvaluations->whereHas('family', function ($query) use ($filters) {
                            $query->where('responsable_name', 'like', '%'.$filters->input('search').'%');
                        });
                        break;
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

        if ($filters->has('filterGroupType') && $filters->input('filterGroupType') != "" && $filters->input('filterGroupType') != "all") {
            $therapistEvaluations = $therapistEvaluations->whereHas('groupMember', function ($query) use ($filters) {
                $query->where('group_id', $filters->input('filterGroupType'));
            });
            $childEvaluations = $childEvaluations->whereHas('groupMember', function ($query) use ($filters) {
                $query->where('group_id', $filters->input('filterGroupType'));
            });
            $familyEvaluations = $familyEvaluations->whereHas('groupMember', function ($query) use ($filters) {
                $query->where('group_id', $filters->input('filterGroupType'));
            });
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

        return view('admin.evaluations.index', compact('evaluations', 'groups', 'superAdmin'));
    }

    public function create($id, $evalType)
    {
        if (!$id || !$evalType || !is_numeric($id) || !in_array($evalType, ['therapist', 'child', 'family'])) {
            return redirect()->route('admin.evaluations');
        }

        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $familyMember = FamilyMember::find($id);
        if ($familyMember) {
            if (!$superAdmin && $familyMember->therapist_id != $therapist->id) {
                return redirect()->route('admin.evaluations');
            }
            if ($evalType == 'therapist') {
                return view('admin.evaluations.therapist', compact('superAdmin', 'familyMember', 'evalType'));
            } elseif ($evalType == 'family') {
                return view('admin.evaluations.family', compact('superAdmin', 'familyMember', 'evalType'));
            } elseif ($evalType == 'child') {
                return view('admin.evaluations.child', compact('superAdmin', 'familyMember', 'evalType'));
            }
        }

        return redirect()->route('admin.evaluations');
    }

    public function edit($id, $evalType)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!in_array($evalType, ['therapist', 'child', 'family'])) {
            return redirect()->route('admin.evaluations');
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

        if (!$superAdmin && $evaluation->therapist_id != $therapist->id) {
            return redirect()->route('admin.evaluations');
        }

        $familyMember = $evaluation->familyMember;

        if ($evaluation->type == 0) {
            return view('admin.evaluations.therapist', compact('superAdmin', 'familyMember', 'evalType', 'evaluation'));
        } elseif ($evaluation->type == 1) {
            return view('admin.evaluations.family', compact('superAdmin', 'familyMember', 'evalType', 'evaluation'));
        } elseif ($evaluation->type == 2) {
            return view('admin.evaluations.child', compact('superAdmin', 'familyMember', 'evalType', 'evaluation'));
        }


        return redirect()->route('admin.evaluations');
    }

    public function destroy($id, $evalType)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin || !in_array($evalType, ['therapist', 'child', 'family'])) {
            return redirect()->route('admin.evaluations');
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

        $evaluation->delete();

        return redirect()->route('admin.evaluations');
    }

    public function storeTherapist(CreateTherapistEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            if (!$superAdmin && $familyMember->therapist_id != $therapist->id) {
                return redirect()->route('admin.evaluations');
            }

            $evaluation = new TherapistEvaluation();
            $evaluation->therapist_id = $therapist->id;
            $evaluation->family_member_id = $familyMember->id;
            $evaluation->family_id = $familyMember->family_id;
            $evaluation->group_member_id = $familyMember->groupMember->id;

            if ($superAdmin && $request->has('meeting_date')) {
                $evaluation->meeting_date = $request->meeting_date;
            } else {
                $evaluation->meeting_date = now();
            }

            $evaluation->child_presence = $request->child_presence;

            // Negative Qualities
            foreach ($evaluation->getNegativeQualitiesAttributes() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
            }

            // Positive Qualities
            foreach ($evaluation->getPositiveQualitiesAttributes() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
            }

            $evaluation->save();

            return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'therapist']);
        }

        return redirect()->route('admin.evaluations');
    }


    public function updateTherapist($id, UpdateTherapistEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        if (!$superAdmin) {
            return redirect()->route('admin.evaluations');
        }
        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            $evaluation = TherapistEvaluation::find($id);
            if ($evaluation) {
                $evaluation->meeting_date = $request->meeting_date;
                $evaluation->child_presence = $request->child_presence;

                // Negative Qualities
                foreach ($evaluation->getNegativeQualitiesAttributes() as $attributeKey => $attributeMessage) {
                    $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
                }

                // Positive Qualities
                foreach ($evaluation->getPositiveQualitiesAttributes() as $attributeKey => $attributeMessage) {
                    $evaluation->$attributeKey = $request->has($attributeKey) ? 1 : 0;
                }

                $evaluation->save();

                return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'therapist']);
            }
        }
        return redirect()->route('admin.evaluations');
    }


    public function storeFamily(CreateFamilyEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            if (!$superAdmin && $familyMember->therapist_id != $therapist->id) {
                return redirect()->route('admin.evaluations');
            }

            $evaluation = new FamilyEvaluation();
            $evaluation->therapist_id = $therapist->id;
            $evaluation->family_member_id = $familyMember->id;
            $evaluation->family_id = $familyMember->family_id;
            $evaluation->group_member_id = $familyMember->groupMember->id;

            if ($superAdmin && $request->has('meeting_date')) {
                $evaluation->meeting_date = $request->meeting_date;
            } else {
                $evaluation->meeting_date = now();
            }

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

            return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'family']);
        }

        return redirect()->route('admin.evaluations');
    }

    public function updateFamily($id, UpdateFamilyEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        if (!$superAdmin) {
            return redirect()->route('admin.evaluations');
        }
        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            $evaluation = FamilyEvaluation::find($id);
            if ($evaluation) {
                $evaluation->meeting_date = $request->meeting_date;

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

                return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'family']);
            }
        }
        return redirect()->route('admin.evaluations');
    }


    public function storeChild(CreateChildEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            if (!$superAdmin && $familyMember->therapist_id != $therapist->id) {
                return redirect()->route('admin.evaluations');
            }

            $evaluation = new ChildEvaluation();
            $evaluation->therapist_id = $therapist->id;
            $evaluation->family_member_id = $familyMember->id;
            $evaluation->family_id = $familyMember->family_id;
            $evaluation->group_member_id = $familyMember->groupMember->id;

            if ($superAdmin && $request->has('meeting_date')) {
                $evaluation->meeting_date = $request->meeting_date;
            } else {
                $evaluation->meeting_date = now();
            }

            // Subjective Answers
            foreach ($evaluation->getAnswersAttribute() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->$attributeKey;
            }

            foreach ($evaluation->getScaleAnswerAttribute() as $attributeKey => $attributeMessage) {
                $evaluation->$attributeKey = $request->$attributeKey;
            }

            $evaluation->save();

            return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'child']);
        }

        return redirect()->route('admin.evaluations');
    }

    public function updateChild(UpdateChildEvaluationFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        if (!$superAdmin) {
            return redirect()->route('admin.evaluations');
        }
        $familyMember = FamilyMember::find($request->family_member_id);
        if ($familyMember) {
            $evaluation = ChildEvaluation::find($request->evaluation_id);
            if ($evaluation) {
                $evaluation->meeting_date = $request->meeting_date;

                // Subjective Answers
                foreach ($evaluation->getAnswersAttribute() as $attributeKey => $attributeMessage) {
                    $evaluation->$attributeKey = $request->$attributeKey;
                }

                foreach ($evaluation->getScaleAnswerAttribute() as $attributeKey => $attributeMessage) {
                    $evaluation->$attributeKey = $request->$attributeKey;
                }

                $evaluation->save();

                return redirect()->route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => 'child']);
            }
        }
        return redirect()->route('admin.evaluations');
    }
}
