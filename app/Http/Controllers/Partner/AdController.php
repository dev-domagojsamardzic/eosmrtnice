<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\AdRequest;
use App\Models\Ad;
use App\Models\Company;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;
use Livewire\Features\SupportRedirects\Redirector;

class AdController extends Controller
{
    public function __construct(protected ImageService  $imageService)
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
     *  Show the form for editing the specified resource.
     *
     * @param Company $company
     * @param Ad $ad
     * @return View
     */
    public function edit(Company $company, Ad $ad): View
    {
        return $this->form($company, $ad, 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdRequest $request, Company $company, Ad $ad): RedirectResponse
    {
        return $this->apply($company, $ad, $request);
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
        $companyLogo = $this->imageService->storeCompanyLogo($request, $company);
        $company->logo = $companyLogo;
        $company->save();

        if ($ad->company()->doesntExist()) {
            $ad->company()->associate($company);
        }
        // Prevent type changing when editing ad
        if ($request->user()->can('set-ad-type', [$ad])) {
            $ad->type = $request->input('type', AdType::STANDARD);
        }
        $ad->title = $request->input('title');
        $ad->months_valid = $request->input('months_valid', 1);
        $ad->caption = $request->input('caption');

        $adBanner = $this->imageService->storeAdBanner($request, $ad);
        $ad->banner = $adBanner;

        try {
            $ad->save();
            return redirect()->route('partner.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
           return redirect()->route('partner.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * @param Company $company
     * @param Ad $ad
     * @return RedirectResponse|Redirector
     */
    public function destroy(Company $company, Ad $ad): RedirectResponse|Redirector
    {
        try {
            $ad->delete();
            return redirect()
                ->route('partner.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }
        catch (Exception $e) {
            return redirect()
                ->route('partner.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
