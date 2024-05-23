<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FamilyMember;
use App\Models\CalendarSchedule;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Http\Requests\CreateCalendarScheduleFormRequest;

class AdminCalendarController extends Controller
{
    public function index()
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        // get all groups
        $groups = Group::all();
        $groupsCss = [ "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info", "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info" ];
        $groupsCssToRgb = [ "form-check-danger" => "rgb(220, 53, 69)", "form-check-nocolor" => "rgb(37, 99, 235)", "form-check-warning" => "rgb(255, 193, 7)", "form-check-success" => "rgb(40, 167, 69)", "form-check-info" => "rgb(23, 162, 184)" ];
        $groupColors = [];
        foreach ($groups as $group) { $groupColors[$group->name] = $groupsCss[$group->id % count($groupsCss)]; }

        // // this month
        // $today = Carbon::now()->setTimezone('America/Sao_Paulo');
        // $startRange = $today->copy()->startOfMonth()->copy();
        // $endRange = $today->copy()->endOfMonth()->copy();

        // // get all calendar schedules between $startRange and $endRange
        // $calendarSchedules = CalendarSchedule::where('start', '>=', $startRange)->where('end', '<=', $endRange);
        // if (!$superAdmin) { $calendarSchedules = $calendarSchedules->ByTherapist($therapist->id); }

        // $calendarSchedules = $calendarSchedules->get();

        // foreach ($calendarSchedules as $calendarSchedule) {
        //     $start = Carbon::parse($calendarSchedule->start);
        //     $end = Carbon::parse($calendarSchedule->end);

        //     $events[] = [
        //         'id' => $calendarSchedule->id,
        //         'title' => $calendarSchedule->familyMember->name,
        //         'start' => $start,
        //         'end' => $end,
        //         'url' => route('admin.families.edit', ['id' => $calendarSchedule->family->id, '#familyMembersArea']),
        //         'color' => $groupsCssToRgb[$groupColors[$calendarSchedule->groupMember->group->name]],
        //     ];
        // }

        $groupsArray = [];
        $groups = Group::all();
        foreach ($groups as $group) {
            foreach ($group->schedules as $schedule) {
                $groupsArray[$schedule->id] = [
                    'name' => $group->name,
                    'day' => $schedule->getDayNameAttribute(),
                    'start' => $schedule->start,
                    'end' => $schedule->end,
                ];
            }
        }

        return view('admin.calendar.index', compact('groupColors', 'groups', 'groupsArray'));
    }

    // load?start=2024-03-31T00%3A00%3A00-03%3A00&end=2024-05-12T00%3A00%3A00-03%3A00
    public function load(Request $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $today = Carbon::now()->setTimezone('America/Sao_Paulo');
        $startRange = $today->copy()->startOfMonth()->copy();
        $endRange = $today->copy()->endOfMonth()->copy();

        $start = Carbon::parse($request->start) ?? $startRange;
        $end = Carbon::parse($request->end) ?? $endRange;

        // create $events with GroupSchedule from familyMembers to populate fullcalendar.io
        $events = [];

        // get all groups
        $groups = Group::all();
        $groupsCss = [ "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info", "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info" ];
        $groupsCssToRgb = [ "form-check-danger" => "rgb(220, 53, 69)", "form-check-nocolor" => "rgb(37, 99, 235)", "form-check-warning" => "rgb(255, 193, 7)", "form-check-success" => "rgb(40, 167, 69)", "form-check-info" => "rgb(23, 162, 184)" ];
        $groupColors = [];
        foreach ($groups as $group) { $groupColors[$group->name] = $groupsCss[$group->id % count($groupsCss)]; }


        // get all calendar schedules between $start and $end
        $calendarSchedules = CalendarSchedule::where('start', '>=', $start)->where('end', '<=', $end);
        if (!$superAdmin) { $calendarSchedules = $calendarSchedules->ByTherapist($therapist->id); }

        $calendarSchedules = $calendarSchedules->get();

        foreach ($calendarSchedules as $calendarSchedule) {
            $start = Carbon::parse($calendarSchedule->start);
            $end = Carbon::parse($calendarSchedule->end);

            $events[] = [
                'id' => $calendarSchedule->id,
                'title' => $calendarSchedule->familyMember->name,
                'start' => $start,
                'end' => $end,
                'url' => route('admin.families.edit', ['id' => $calendarSchedule->family->id, '#familyMembersArea']),
                'evalTherapist' => route('admin.evaluations.create', ['id' => $calendarSchedule->familyMember->id, 'evalType' => 'therapist']),
                'color' => $groupsCssToRgb[$groupColors[$calendarSchedule->groupMember->group->name]],
            ];
        }

        return response()->json($events);

    }

    public function destroy($id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $calendarSchedule = CalendarSchedule::find($id);
        if ($calendarSchedule) {
            if ($superAdmin || $calendarSchedule->therapist_id == $therapist->id) {
                $calendarSchedule->delete();
            }
        }

        return redirect()->route('admin.calendar');
    }


    public function schedule(CreateCalendarScheduleFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        // get all family member with group schedule id
        $groupSchedule = GroupSchedule::find($request->member_group_schedule);

        $familyMembers = FamilyMember::whereHas('groupMember', function ($query) use ($request) {
            $query->where('group_schedule_id', $request->member_group_schedule);
        });

        if (!$superAdmin) {
            $familyMembers = $familyMembers->ByTherapist($therapist->id);
        }



        // remove all family members that already have a schedule for this group schedule in this meeting date
        $calendarSchedules = CalendarSchedule::where('start', '>=', $request->member_meeting_date . ' ' . $groupSchedule->start)
            ->where('end', '<=', $request->member_meeting_date . ' ' . $groupSchedule->end)
            ->where('group_schedule_id', $groupSchedule->id);

        $familyMembers = $familyMembers->whereNotIn('id', $calendarSchedules->pluck('family_member_id'));


        // create calendar schedule for each family member
        foreach ($familyMembers->get() as $familyMember) {
            CalendarSchedule::create([
                'therapist_id' => $familyMember->therapist_id,
                'family_id' => $familyMember->family->id,
                'family_member_id' => $familyMember->id,
                'group_member_id' => $familyMember->groupMember->id,
                'group_schedule_id' => $groupSchedule->id,
                'start' => $request->member_meeting_date . ' ' . $groupSchedule->start,
                'end' => $request->member_meeting_date . ' ' . $groupSchedule->end,
            ]);
        }

        return redirect()->route('admin.calendar');
    }
}
