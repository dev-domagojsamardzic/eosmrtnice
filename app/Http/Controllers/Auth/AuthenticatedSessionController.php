<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if(auth()->user()->type === UserType::ADMIN) {
            return redirect()
                ->intended(RouteServiceProvider::ADMIN)
                ->with('alert', ['class' => 'success', 'message' => __('common.you_are_logged_in')]);
        }

        if(auth()->user()->type === UserType::PARTNER) {
            return redirect()
                ->intended(RouteServiceProvider::PARTNER)
                ->with('alert', ['class' => 'success', 'message' => __('common.you_are_logged_in')]);
        }

        if(auth()->user()->type === UserType::MEMBER) {
            return redirect()
                ->intended(RouteServiceProvider::MEMBER)
                ->with('alert', ['class' => 'success', 'message' => __('common.you_are_logged_in')]);
        }

        return redirect()
            ->route('login')
            ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
