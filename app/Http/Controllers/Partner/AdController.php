<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\AdRequest;
use App\Models\Ad;
use App\Models\Company;
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
     * @param Company $company
     * @return View
     */
    public function create(Company $company): View
    {
        return $this->form($company, new Ad, 'create');
    }

    /**
     * Store new resource
     * @param Company $company
     * @param AdRequest $request
     * @return RedirectResponse
     */
    public function store(Company $company, AdRequest $request):RedirectResponse
    {
        return $this->apply($company, new Ad, $request);
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
     * @param Company $company
     * @param Ad $ad
     * @param string $action
     * @return View
     */
    private function form(Company $company, Ad $ad, string $action): View
    {
        $types = AdType::options();
        //$companies = auth()->user()->companies()->has('ad', '=', 0)->get() ?? collect();

        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads.update', ['company' => $company, 'ad' => $ad]),
            'create' => route(auth_user_type() . '.ads.store', ['company' => $company]),
            default => ''
        };
        $quit = route(auth_user_type() . '.ads.index');

        return view('partner.ads.form',[
            'company' => $company,
            'ad' => $ad,
            'types' => $types,
            'action_name' => $action,
            'action' => $route,
            'quit' => $quit,
        ]);
    }

    /**
     * Apply changes on resource
     * @param Company $company
     * @param Ad $ad
     * @param AdRequest $request
     * @return RedirectResponse
     */
    private function apply(Company $company, Ad $ad, AdRequest $request): RedirectResponse
    {
        if ($ad->company()->doesntExist()) {
            $ad->company()->associate($company);
        }
        $ad->type = $request->input('type', 1);
        $ad->months_valid = $request->input('months_valid', 1);
        $ad->caption = $request->input('caption');

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
