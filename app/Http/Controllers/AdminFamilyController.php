<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupSchedule;
use App\Http\Requests\CreateFamilyFormRequest;
use App\Http\Requests\CreateFamilyMemberFormRequest;
use App\Http\Requests\UpdateFamilyFormRequest;
use App\Http\Requests\UpdateFamilyMemberFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AdminFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // families index
    public function families(Request $filters, $page = 1) : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        $page = $filters->input('page') ?? 1;

        $families = $superAdmin ? new Family() : Family::whereHas('members', function ($query) use ($therapist) {
            $query->where('therapist_id', $therapist->id);
        });

        if ($filters->has('search') && $filters->has('filterFamilyType') && $filters->input('search') != "" && $filters->input('filterFamilyType') != "") {
            switch ($filters->input('filterFamilyType')) {
                case 'resDocument':
                    $families = $families->where('responsable_document', 'like', '%'.$filters->input('search').'%');
                    break;
                case 'resName':
                    $families = $families->where('responsable_name', 'like', '%'.$filters->input('search').'%');
                    break;
            }
        }

        $families = $families->orderBy('id', 'desc')->paginate(10, ['*'], 'page', $page);

        return view('admin.families.list', compact('families', 'superAdmin'));
    }


    // members index
    public function members(Request $filters, $page = 1) : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;
        $page = $filters->input('page') ?? 1;
        $familyMembers = $superAdmin ? new FamilyMember() : FamilyMember::ByTherapist($therapist->id);

        if ($filters->has('search') && $filters->has('filterFamilyType') && $filters->input('search') != "" && $filters->input('filterFamilyType') != "") {
            switch ($filters->input('filterFamilyType')) {
                case 'resDocument':
                    $familyMembers = $familyMembers->whereHas('family', function ($query) use ($filters) {
                        $query->where('responsable_document', 'like', '%'.$filters->input('search').'%');
                    });
                    break;
                case 'resName':
                    $familyMembers = $familyMembers->whereHas('family', function ($query) use ($filters) {
                        $query->where('responsable_name', 'like', '%'.$filters->input('search').'%');
                    });
                    break;
                case 'memberDocument':
                    $familyMembers = $familyMembers->where('document', 'like', '%'.$filters->input('search').'%');
                    break;
                case 'memberName':
                    $familyMembers = $familyMembers->where('name', 'like', '%'.$filters->input('search').'%');
                    break;
            }
        }

        if ($filters->has('filterGroupType') && $filters->input('filterGroupType') != "" && $filters->input('filterGroupType') != "all") {
            $familyMembers = $familyMembers->whereHas('groupMember', function ($query) use ($filters) {
                $query->where('group_id', $filters->input('filterGroupType'));
            });
        }

        $familyMembers = $familyMembers->orderBy('id', 'desc')->paginate(10, ['*'], 'page', $page);

        $groups = Group::all();

        return view('admin.families.memberslist', compact('familyMembers', 'groups', 'superAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        return view('admin.families.data', compact('superAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFamilyFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $today = Carbon::now();

        $family = Family::create([
            'active' => 1,
            'responsable_name' => $request->responsable_name,
            'responsable_document' => preg_replace('/\D/', '', $request->responsable_document),
            'email' => $request->email,
            'phone' => preg_replace('/\D/', '', $request->phone),
            'address' => $request->address,
            'zip' => $request->zip,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        if ($request->hasFile('familyImage') != null) {
            $fileName = $family->id . '_' . uniqid() . '.' . $request->file('familyImage')->getClientOriginalExtension();
            $request->file('familyImage')->storeAs('public/uploads', $fileName);
            $family->avatar = $fileName;
        }

        $family->save();

        // redireciona para a página do sorteio criado
        return redirect()->route('admin.families.edit', ['id' => $family->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) : View
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $family = Family::find($id);
        if ($family) {

            $familyMembers = FamilyMember::ByFamily($family->id);
            if (!$superAdmin) {
                $familyMembers = $familyMembers->ByTherapist($therapist->id);
            }
            $familyMembers = $familyMembers->get();

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

            $therapists = User::all();

            return view('admin.families.data', compact('superAdmin', 'family', 'familyMembers', 'groupsArray', 'therapists'));
        }

        return view('admin.families.data');
    }

    public function update($id, UpdateFamilyFormRequest $request)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        if (!$superAdmin) { return redirect()->route('admin.families.list'); }

        $family = Family::find($id);
        $success = false;
        if ($family) {
            $family->responsable_name = $request->responsable_name;
            $family->responsable_document = preg_replace('/\D/', '', $request->responsable_document);
            $family->email = $request->email;
            $family->phone = preg_replace('/\D/', '', $request->phone);
            $family->address = $request->address;
            $family->zip = $request->zip;
            $family->city = $request->city;
            $family->state = $request->state;
            $family->active = $request->active;

            if ($request->hasFile('familyImage') != null) {
                $fileName = $family->id . '_' . uniqid() . '.' . $request->file('familyImage')->getClientOriginalExtension();
                $request->file('familyImage')->storeAs('public/uploads', $fileName);
                $family->avatar = $fileName;
            }

            $success = $family->save();
        }

        return redirect()->route('admin.families.edit', ['id' => $family->id])->with('success', $success);
    }

    public function storeMembers($id, CreateFamilyMemberFormRequest $request) : RedirectResponse
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $family = Family::find($id);
        $groupSchedule = GroupSchedule::find($request->member_group_schedule);
        $success = false;
        if ($family && $groupSchedule) {
            $familyMember = FamilyMember::create([
                'family_id' => $family->id,
                'name' => $request->member_name,
                'document' => $request->member_document,
                'birth_date' => $request->member_birth_date,
                'therapist_id' => $superAdmin ? $request->member_therapist_id : $therapist->id,
            ]);

            if ($request->hasFile('member_image') != null) {
                $fileName = $familyMember->id . '_' . uniqid() . '.' . $request->file('member_image')->getClientOriginalExtension();
                $request->file('member_image')->storeAs('public/uploads', $fileName);
                $familyMember->avatar = $fileName;
            }

            $success = $familyMember->save();

            $familyMemberGroupSchedule = GroupMember::create([
                'group_id' => $groupSchedule->group_id,
                'family_member_id' => $familyMember->id,
                'group_schedule_id' => $groupSchedule->id,
                'status' => 0, // Atendendo
                'status_date' => \Carbon\Carbon::now(),
            ]);
        }
        return redirect()->route('admin.families.edit', ['id' => $family->id, '#familyMembersArea'])->with('success', $success);
    }

    public function editMembers($id, UpdateFamilyMemberFormRequest $request) : RedirectResponse
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $family = Family::find($id);

        if (empty($id) || !$family) {
            return redirect()->route('admin.families.index');
        }

        $familyMember = FamilyMember::find($request->family_member_id);
        $groupSchedule = GroupSchedule::find($request->member_group_schedule);

        $success = false;
        if ($family && $familyMember && $groupSchedule) {
            if ($superAdmin) {
                $familyMember->name = $request->member_name;
                $familyMember->document = $request->member_document;
                $familyMember->birth_date = $request->member_birth_date;
                $familyMember->therapist_id = $request->member_therapist_id;

                if ($familyMember->groupMember->group_schedule_id != $groupSchedule->id) {
                    $familyMember->groupMember->group_id = $groupSchedule->group_id;
                    $familyMember->groupMember->group_schedule_id = $groupSchedule->id;
                    $familyMember->groupMember->status = 0;
                    $familyMember->groupMember->status_date = \Carbon\Carbon::now();
                    $familyMember->groupMember->save();
                }

                if ($request->hasFile('member_image') != null) {
                    $fileName = $familyMember->id . '_' . uniqid() . '.' . $request->file('member_image')->getClientOriginalExtension();
                    $request->file('member_image')->storeAs('public/uploads', $fileName);
                    $familyMember->avatar = $fileName;
                }
            }
            $success = $familyMember->save();
        }
        return redirect()->route('admin.families.edit', ['id' => $family->id, '#familyMembersArea'])->with('success', $success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $family = Family::find($id);
        $success = false;
        if ($family && $superAdmin) {
            try {
                $success = $family->delete();
            } catch (\Exception $e) {
                // Log the exception or return with error
                \Log::error($e->getMessage());
                $success = false;
            }
        }

        return redirect()->route('admin.families.list')->with('success', $success);
    }

    public function destroyMembers(string $id)
    {
        $therapist = auth()->user();
        $superAdmin = $therapist->superadmin == true;

        $familyMember = FamilyMember::find($id);
        if (!$familyMember) {
            return redirect()->route('admin.families.members');
        }
        $familyId = $familyMember->family_id;

        $success = false;
        if ($familyMember && $superAdmin) {
            try {
                $familyId = $familyMember->family_id;
                $success = $familyMember->delete();

                return redirect()->route('admin.families.edit', ['id' => $familyId, '#familyMembersArea'])->with('success', $success);
            } catch (\Exception $e) {
                // Log the exception or return with error
                \Log::error($e->getMessage());
                $success = false;

                return redirect()->route('admin.families.edit', ['id' => $familyId])->with(['error' => true, 'message' => 'Não foi possível excluir o membro da família.']);
            }
        }
        return redirect()->route('admin.families.edit', ['id' => $familyId, '#familyMembersArea']);
    }
}
