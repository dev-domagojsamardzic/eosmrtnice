<?php

namespace App\Http\Controllers\Auth\Partner;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\RegisterRequest as PartnerRegisterRequest;
use App\Models\Company;
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
    public function store(PartnerRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'type' => UserType::PARTNER,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $company = Company::create([
            'title' => $request->company_title,
            'user_id' => $user->id,
            'address' => $request->company_address,
            'town' => $request->company_town,
            'zipcode' => $request->company_zipcode,
            'oib' => $request->company_oib,
            'email' => $request->company_email,
            'phone' => $request->company_phone,
            'mobile_phone' => $request->company_mobile_phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::PARTNER);
    }
}
