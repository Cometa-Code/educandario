<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FamilyMember;
use App\Models\TherapistEvaluation;
use App\Models\ChildEvaluation;
use App\Models\FamilyEvaluation;
use Carbon\Carbon;


class AdminReportController extends Controller
{
    public $selectColumns = ['id', 'therapist_id', 'family_member_id', 'group_member_id', 'family_id', 'created_at', 'type', 'meeting_date'];

    public function index(Request $filters, $page = 1) : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        $page = $filters->input('page') ?? 1;

        $today = Carbon::now()->setTimezone('America/Sao_Paulo');

        // startDate or today
        $startDate = $filters->input('startDate') ?? $today->copy()->subDays(30)->copy();
        $endDate = $filters->input('endDate') ?? $today->copy();

        $therapistEvaluations = $superAdmin ? new TherapistEvaluation() : TherapistEvaluation::ByTherapist($therapist->id);
        $familyEvaluations = $superAdmin ? new FamilyEvaluation() : FamilyEvaluation::ByTherapist($therapist->id);

        if ($filters->has('search') && $filters->has('filterFamilyType') && $filters->input('search') != "" && $filters->input('filterFamilyType') != "") {
            if ($filters->has('filterFamilyType') && $filters->input('filterFamilyType') != "") {
                switch ($filters->input('filterFamilyType')) {
                    case 'memberDocument':
                        $therapistEvaluations = $therapistEvaluations->whereHas('familyMember', function ($query) use ($filters) {
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
                $familyEvaluations = $familyEvaluations->whereHas('familyMember', function ($query) use ($filters) {
                    $query->where('name', 'like', '%'.$filters->input('search').'%');
                });
            }
        }

        $therapistEvaluations = $therapistEvaluations->whereBetween('meeting_date', [$startDate, $endDate]);
        $familyEvaluations = $familyEvaluations->whereBetween('meeting_date', [$startDate, $endDate]);

        $evaluations = [];
        $evalType = 0;
        if ($filters->has('filterEvaluationType') && $filters->input('filterEvaluationType') != "" && $filters->input('filterEvaluationType') != "all") {
            switch ($filters->input('filterEvaluationType')) {
                case 'family':
                    $evalType = 1;
                    $evaluations = $familyEvaluations;
                    break;
                default:
                    $evaluations = $therapistEvaluations;
            }
        } else {
            $evaluations = $therapistEvaluations;
        }

        // foreach every evaluation, group by familyMember, calculate score and mount the array for chartjs
        $familyMembers = [];
        foreach ($evaluations->get() as $evaluation) {
            $familyMember = $evaluation->familyMember;
            $familyMemberId = $familyMember->id;
            if (!isset($familyMembers[$familyMemberId])) {
                $familyMembers[$familyMemberId] = [
                    'id' => $familyMemberId,
                    'name' => $familyMember->name,
                    'document' => $familyMember->document,
                    'evaluations' => [],
                ];
            }
            $familyMembers[$familyMemberId]['evaluations'][] = $evaluation;
        }

        // $therapistEvaluations = $therapistEvaluations->orderBy('meeting_date', 'desc')->paginate(10, $this->selectColumns);
        // $childEvaluations = $childEvaluations->orderBy('meeting_date', 'desc')->paginate(10, $this->selectColumns);
        // $familyEvaluations = $familyEvaluations->orderBy('meeting_date', 'desc')->paginate(10, $this->selectColumns);





        return view('admin.reports.index', compact('familyMembers', 'page', 'superAdmin', 'evalType'));
    }
}
