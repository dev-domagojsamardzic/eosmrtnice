<?php

namespace App\Http\Controllers\Auth\Partner;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth/partner.register');
    }

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'type' => UserType::PARTNER,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // TODO: create new company

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::PARTNER);
    }
}
