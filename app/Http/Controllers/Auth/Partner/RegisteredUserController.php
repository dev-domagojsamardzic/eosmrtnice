<?php

namespace App\Http\Controllers\Auth\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\RegisterRequest as PartnerRegisterRequest;
use App\Models\Company;
use App\Models\Partner;
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
        $user = new Partner();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->sex = $request->sex;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $company = new Company();
        $company->title = $request->company_title;
        $company->user()->associate($user);
        $company->address = $request->company_address;
        $company->town = $request->company_town;
        $company->zipcode = $request->company_zipcode;
        $company->oib = $request->company_oib;
        $company->email = $request->company_email;
        $company->phone = $request->company_phone;
        $company->mobile_phone = $request->company_mobile_phone;
        $company->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::PARTNER);
    }
}
