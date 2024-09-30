<?php

namespace App\Http\Controllers\Auth\Partner;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\RegisterRequest as PartnerRegisterRequest;
use App\Models\Company;
use App\Models\Partner;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
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
        $genders = Gender::options();

        return view('auth/partner.register', [
            'genders' => $genders,
            'gender_default' => Gender::MALE->value,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(PartnerRegisterRequest $request): RedirectResponse
    {
        $user = new Partner();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->gender = $request->input('gender');
        $user->birthday = Carbon::createFromFormat('d.m.Y.', $request->birthday)->toDateString();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $company = new Company();
        $company->title = $request->input('company_title');
        $company->user()->associate($user);
        $company->address = $request->input('company_address');
        $company->town = $request->input('company_town');
        $company->zipcode = $request->input('company_zipcode');
        $company->oib = $request->input('company_oib');
        $company->email = $request->input('company_email');
        $company->phone = $request->input('company_phone');
        $company->mobile_phone = $request->input('company_mobile_phone');
        $company->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::PARTNER);
    }
}
