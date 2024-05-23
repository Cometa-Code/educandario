<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\Families\FamilyLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Family;

use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;

use Illuminate\Support\Facades\Mail;
use App\Mail\FamilyLoginMail;

class FamilyLoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // check if already logged
        if (Auth::guard('families')->check()) {
            return redirect(RouteServiceProvider::HOME_FAMILIES);
        }
        return view('families.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(FamilyLoginRequest $request)
    {
        $request->checkIfIsNotRateLimited();
        $request->session()->regenerate();

        $family = Family::where('email', $request->email)->first();
        if (!$family) {
            return back()->withErrors(['email' => 'E-mail não encontrado']);
        }

        $action = new LoginAction($family);
        $action->response(redirect('/families/'));
        $action->guard('families');
        $action->remember(true);

        $magicLinkLogin = MagicLink::create($action);

        $urlToLogin = $magicLinkLogin->url;
        $responsableName = $family->responsable_name;

        Mail::to($family->email)->send(new FamilyLoginMail($responsableName, $urlToLogin));

        return view('families.auth.sended');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('families')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME_FAMILIES);
    }
}
