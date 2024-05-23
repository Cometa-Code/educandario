<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FamilyMember;
use App\Models\TherapistEvaluation;
use App\Models\ChildEvaluation;
use App\Models\FamilyEvaluation;
use Carbon\Carbon;


class FamilyReportController extends Controller
{
    public $selectColumns = ['id', 'therapist_id', 'family_member_id', 'group_member_id', 'family_id', 'created_at', 'type', 'meeting_date'];

    public function index(Request $filters, $page = 1) : View
    {
        $family = auth()->user();
        $page = $filters->input('page') ?? 1;

        $today = Carbon::now()->setTimezone('America/Sao_Paulo');

        // startDate or today
        $startDate = $filters->input('startDate') ?? $today->copy()->subDays(30)->copy();
        $endDate = $filters->input('endDate') ?? $today->copy();

        $therapistEvaluations = TherapistEvaluation::where('family_id', $family->id);
        $familyEvaluations = FamilyEvaluation::where('family_id', $family->id);

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

        return view('families.reports.index', compact('familyMembers', 'page', 'evalType'));
    }
}
