<?php

namespace App\Http\Controllers\User;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeceasedRequest;
use App\Models\City;
use App\Models\County;
use App\Models\Deceased;
use App\Services\ImageService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class DeceasedController extends Controller
{
    public function __construct(protected ImageService $imageService) {

    }

    /**
     * Show all resources
     *
     * @return View
     */
    public function index(): View
    {
        return view(auth_user_type() . '.deceaseds.index');
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
     * Show resource's edit form
     *
     * @param Deceased $deceased
     * @return View
     */
    public function edit(Deceased $deceased): View
    {
        return $this->form($deceased, 'edit');
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
     * Update resource
     *
     * @param Deceased $deceased
     * @param DeceasedRequest $request
     * @return RedirectResponse
     */
    public function update(Deceased $deceased, DeceasedRequest $request): RedirectResponse
    {
        return $this->apply($deceased, $request);
    }

    /**
     * Delete resource
     *
     * @param Deceased $deceased
     * @return RedirectResponse|Redirector
     */
    public function destroy(Deceased $deceased): RedirectResponse|Redirector
    {
        try {
            $deceased->delete();
            return redirect()
                ->route(auth_user_type() . '.deceaseds.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }
        catch (Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.deceaseds.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
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
            'edit' => route(auth_user_type() . '.deceaseds.update', ['deceased' => $deceased->id]),
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
        $deceasedImage = $this->imageService->storeDeceasedImage($request, $deceased);
        $deceased->image = $deceasedImage;

        $deceased->user()->associate($request->user());
        $deceased->gender = $request->input('gender');
        $deceased->first_name = $request->input('first_name');
        $deceased->last_name = $request->input('last_name');
        $deceased->maiden_name = $request->input('maiden_name');
        $deceased->date_of_birth = Carbon::parse($request->input('date_of_birth'))->format('Y-m-d');
        $deceased->date_of_death = Carbon::parse($request->input('date_of_death'))->format('Y-m-d');
        $deceased->city()->associate($request->input('city_id'));
        $deceased->county()->associate($request->input('county_id'));

        try {
            $deceased->save();
            return redirect()->route('user.deceaseds.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch (\Exception $e) {
            return redirect()
                ->route('user.deceaseds.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
