<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChildEvaluation;
use App\Models\TherapistEvaluation;
use App\Models\FamilyEvaluation;
use App\Models\FamilyMember;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $family = auth()->user();

        $childEvals = ChildEvaluation::where('family_id', $family->id)->count();
        $therapistEvals = TherapistEvaluation::where('family_id', $family->id)->count();
        $familyEvals = FamilyEvaluation::where('family_id', $family->id)->count();

        $familyMembers = FamilyMember::where('family_id', $family->id)->get();

        $home = [
            'total_members' => $familyMembers->count(),
            'total_evalutations' => $childEvals + $therapistEvals + $familyEvals
        ];
        // Auth::guard('families')->logout();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return view('families.home.index', compact('home', 'familyMembers'));
    }

    public function profile(Request $request)
    {
        $family = auth()->user();
        $familyMembers = FamilyMember::where('family_id', $family->id)->get();

        return view('families.home.data', compact('family', 'familyMembers'));
    }

}
