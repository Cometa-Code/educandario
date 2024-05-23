<?php

namespace App\Http\Controllers;

use App\Models\ChildEvaluation;
use App\Models\TherapistEvaluation;
use App\Models\FamilyEvaluation;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\GroupMember;
use App\Http\Requests\UpdatePasswordFormRequest;
use App\Http\Requests\UpdateProfileFormRequest;

use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $therapistId = auth()->user()->id;
        $superAdmin = auth()->user()->superadmin;
        $today = \Carbon\Carbon::now();

        $total_therapists_eval = $superAdmin ? TherapistEvaluation::count() : TherapistEvaluation::ByTherapist($therapistId)->count();
        $total_children_eval = $superAdmin ? ChildEvaluation::count() : ChildEvaluation::ByTherapist($therapistId)->count();
        $total_families_eval = $superAdmin ? FamilyEvaluation::count() : FamilyEvaluation::ByTherapist($therapistId)->count();


        // if not superAdmin, count all families have a member with the therapistId
        $total_families = $superAdmin ? Family::count() : Family::whereHas('members', function ($query) use ($therapistId) {
            $query->where('therapist_id', $therapistId);
        })->count();

        $home = [
            'total_members' => $superAdmin ? GroupMember::count() : GroupMember::ByTherapist($therapistId)->count(),
            'total_evalutations' => $total_therapists_eval + $total_children_eval + $total_families_eval,
            'total_families' => $total_families,
            'completed_services' => GroupMember::ByTherapist($therapistId)->Status(1)->count(),
        ];

        // get all familymembers have groupschedule with the current day
        $familyMembers = FamilyMember::whereHas('groupMember', function ($query) use ($today) {
            $query->whereHas('groupSchedule', function ($query) use ($today) {
                $query->where('day', $today->dayOfWeek+1);
            });
        });

        $familyMembers = $superAdmin ? $familyMembers->latest()->take(10)->get() : $familyMembers->ByTherapist($therapistId)->latest()->take(10)->get();

        return view('admin.home.index', compact('home', 'familyMembers', 'superAdmin'));
    }

    public function profile()
    {
        $therapist = auth()->user();
        return view('admin.home.profile', compact('therapist'));
    }

    public function updateProfile(UpdateProfileFormRequest $request) {
        $therapist = auth()->user();
        // update name on $therapist and save
        $therapist->name = $request->name;
        $therapist->save();

        // check if $therapist->profile is null
        if ($therapist->profile == null) {
            $therapist->profile()->create([
                'document' => $request->document,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'zip' => $request->zip,
                'city' => $request->city,
                'state' => $request->state,
                'specialty' => $request->specialty,
            ]);
            $therapist = auth()->user();
        } else {
            // update all requests on $therapist profile
            $therapist->profile->document = $request->document;
            $therapist->profile->phone = $request->phone;
            $therapist->profile->birth_date = $request->birth_date;
            $therapist->profile->address = $request->address;
            $therapist->profile->zip = $request->zip;
            $therapist->profile->city = $request->city;
            $therapist->profile->state = $request->state;
            $therapist->profile->specialty = $request->specialty;
        }
        // check if has file
        if ($request->hasFile('userImage') != null) {
            $fileName = $therapist->id . '_' . uniqid() . '.' . $request->file('userImage')->getClientOriginalExtension();
            $request->file('userImage')->storeAs('public/uploads', $fileName);
            $therapist->profile->avatar = $fileName;
        }

        $therapist->profile->save();


        return redirect()->route('admin.profile')->with('success', 'Perfil atualizado com sucesso');

    }


    public function updatePassword(UpdatePasswordFormRequest $request)
    {
        $therapist = auth()->user();

        // check old_password
        if (!\Hash::check($request->old_password, $therapist->password)) {
            return redirect()->route('admin.profile')->with('error', 'Senha atual não confere');
        }

        $therapist->password = bcrypt($request->password);
        $therapist->save();

        return redirect()->route('admin.profile')->with('success', 'Senha atualizada com sucesso');
    }
}
