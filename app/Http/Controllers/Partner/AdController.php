<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\AdRequest;
use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;

class AdController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ad::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('partner.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return $this->form(new Ad, 'create');
    }

    /**
     * Store new resource
     * @param AdRequest $request
     * @return RedirectResponse
     */
    public function store(AdRequest $request):RedirectResponse
    {
        return $this->apply(new Ad, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        //
    }

    /**
     * Display resource's form
     * @param Ad $ad
     * @param string $action
     * @return View
     */
    private function form(Ad $ad, string $action): View
    {
        $types = AdType::options();
        $companies = auth()->user()->companies ?? collect();

        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads.update', ['ad' => $ad]),
            'create' => route(auth_user_type() . '.ads.store'),
            default => ''
        };
        $quit = route(auth_user_type() . '.ads.index');

        return view('partner.ads.form',[
            'ad' => $ad,
            'types' => $types,
            'companies' => $companies,
            'action_name' => $action,
            'action' => $route,
            'quit' => $quit,
        ]);
    }

    /**
     * Apply changes on resource
     * @param Ad $ad
     * @param AdRequest $request
     * @return RedirectResponse
     */
    private function apply(Ad $ad, AdRequest $request): RedirectResponse
    {
        $ad->company()->associate($request->input('company_id'));
        $ad->months_valid = $request->input('months_valid');

        try {
            $ad->save();
            return redirect()->route('partner.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
           return redirect()->route('partner.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
