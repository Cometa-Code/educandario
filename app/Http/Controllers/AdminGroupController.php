<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Http\Requests\CreateOrUpdateGroupFormRequest;
use App\Http\Requests\CreateOrUpdateGroupScheduleFormRequest;


class AdminGroupController extends Controller
{
    public function index(Request $filters, $page = 1) : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        $page = $filters->input('page') ?? 1;

        $groups = Group::paginate(10);

        return view('admin.groups.index', compact('groups', 'superAdmin'));
    }

    public function create() : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        return view('admin.groups.data', compact('superAdmin'));
    }

    public function store(CreateOrUpdateGroupFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $group = Group::create($request->only('name'));
        if ($group) {
            return redirect()->route('admin.groups.edit', ['id' => $group->id]);
        } else {
            return redirect()->route('admin.groups');
        }
    }
    public function edit($id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $group = Group::find($id);
        if ($group && $superAdmin) {
            return view('admin.groups.data', compact('superAdmin', 'group'));
        }

        return redirect()->route('admin.groups');
    }
    public function update($id, CreateOrUpdateGroupFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $group = Group::find($id);
        $success = false;
        if ($group) {
            $success = $group->update($request->only('name'));
        }

        return redirect()->route('admin.groups.edit', ['id' => $group->id])->with('success', $success);
    }
    public function destroy($id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $group = Group::find($id);
        $success = false;
        if ($group) {
            $success = $group->delete();
        }

        return redirect()->route('admin.groups')->with('success', $success);
    }

    public function storeSchedules($id, CreateOrUpdateGroupScheduleFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $group = Group::find($id);
        $success = false;
        if ($group) {
            $schedule = GroupSchedule::create([
                'group_id' => $group->id,
                'active' => $request->input('schedule_active'),
                'day' => $request->input('schedule_day'),
                'start' => $request->input('schedule_start'),
                'end' => $request->input('schedule_end'),
            ]);
            $success = $schedule ? true : false;
        }

        return redirect()->route('admin.groups.edit', ['id' => $group->id])->with('success', $success);
    }

    public function editSchedules($id, CreateOrUpdateGroupScheduleFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $group = Group::find($id);
        $success = false;

        if ($group && $request->has('schedule_id')) {
            $schedule = GroupSchedule::find($request->input('schedule_id'));

            if ($schedule) {
                $success = $schedule->update([
                    'active' => $request->input('schedule_active'),
                    'day' => $request->input('schedule_day'),
                    'start' => $request->input('schedule_start'),
                    'end' => $request->input('schedule_end'),
                ]);


            }
        }

        return redirect()->route('admin.groups.edit', ['id' => $group->id])->with('success', $success);
    }

    public function destroySchedules($id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.groups'); }

        $schedule = GroupSchedule::find($id);
        $success = false;
        if ($schedule) {
            $groupId = $schedule->group_id;
            $success = $schedule->delete();

            return redirect()->route('admin.groups.edit', ['id' => $groupId])->with('success', $success);
        }
        return redirect()->route('admin.groups')->with('success', $success);
    }
}
