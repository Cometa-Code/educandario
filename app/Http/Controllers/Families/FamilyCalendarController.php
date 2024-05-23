<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Group;
use App\Models\CalendarSchedule;
use Carbon\Carbon;


class FamilyCalendarController extends Controller
{
    public function index()
    {
        $family = auth()->user();

        // get all groups
        $groups = Group::all();
        $groupsCss = [ "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info", "form-check-danger", "form-check-nocolor", "form-check-warning", "form-check-success", "form-check-info" ];
        $groupsCssToRgb = [ "form-check-danger" => "rgb(220, 53, 69)", "form-check-nocolor" => "rgb(37, 99, 235)", "form-check-warning" => "rgb(255, 193, 7)", "form-check-success" => "rgb(40, 167, 69)", "form-check-info" => "rgb(23, 162, 184)" ];
        $groupColors = [];
        foreach ($groups as $group) { $groupColors[$group->name] = $groupsCss[$group->id % count($groupsCss)]; }

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

        return view('families.calendar.index', compact('groupColors', 'groups', 'groupsArray'));
    }

    public function load(Request $request)
    {
        $family = auth()->user();

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
        $calendarSchedules = CalendarSchedule::ByFamily($family->id)->where('start', '>=', $start)->where('end', '<=', $end)->get();

        foreach ($calendarSchedules as $calendarSchedule) {
            $start = Carbon::parse($calendarSchedule->start);
            $end = Carbon::parse($calendarSchedule->end);

            $events[] = [
                'id' => $calendarSchedule->id,
                'title' => $calendarSchedule->familyMember->name,
                'start' => $start,
                'end' => $end,
                'color' => $groupsCssToRgb[$groupColors[$calendarSchedule->groupMember->group->name]],
            ];
        }

        return response()->json($events);

    }
}
