<?php

namespace App\Http\Controllers\User;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeceasedRequest;
use App\Models\City;
use App\Models\County;
use App\Models\Deceased;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeceasedController extends Controller
{
    /**
     * Show all resources
     *
     * @return View
     */
    public function index(): View
    {
        return view('user.deceaseds.index');
    }

    /**
     * Show resource's create form
     *
     * @return View
     */
    public function create(): View
    {
        return $this->form(new Deceased, 'create');
    }

    /**
     * Store new resource
     *
     * @param Deceased $deceased
     * @param DeceasedRequest $request
     * @return RedirectResponse
     */
    public function store(Deceased $deceased, DeceasedRequest $request): RedirectResponse
    {
        return $this->apply($deceased, $request);
    }

    /**
     * Display resource's form
     * @param Deceased $deceased
     * @param string $action
     * @return View
     */
    private function form(Deceased $deceased, string $action): View
    {
        $route = match ($action) {
            'create' => route(auth_user_type() . '.deceaseds.store'),
            'update' => route(auth_user_type() . '.deceaseds.update', ['deceased' => $deceased->id]),
            default => '',
        };

        $genderOptions = Gender::options();
        $counties = County::query()
            ->orderBy('title', 'asc')
            ->pluck('title', 'id')
            ->toArray();
        $cities = City::query()
            ->orderBy('title')
            ->get();

        return view('user.deceaseds.form', [
            'genderOptions' => $genderOptions,
            'counties' => $counties,
            'cities' => $cities,
            'deceased' => $deceased,
            'action_name' => $action,
            'action' => $route,
            'quit' => route(auth_user_type() . '.deceaseds.index'),
        ]);
    }

    /**
     * Apply changes to resource
     *
     * @param Deceased $deceased
     * @param DeceasedRequest $request
     * @return RedirectResponse
     */
    private function apply(Deceased $deceased, DeceasedRequest $request): RedirectResponse
    {
        $deceased->gender = $request->input('gender');
        $deceased->first_name = $request->input('first_name');
        $deceased->last_name = $request->input('last_name');
        $deceased->maiden_name = $request->input('maiden_name');
        $deceased->date_of_birth = Carbon::parse($request->input('date_of_birth'))->format('Y-m-d');
        $deceased->date_of_death = Carbon::parse($request->input('date_of_death'))->format('Y-m-d');
    }
}
