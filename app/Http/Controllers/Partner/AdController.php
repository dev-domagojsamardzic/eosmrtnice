<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Enums\CompanyType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\AdRequest;
use App\Models\Ad;
use App\Models\City;
use App\Models\Company;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
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
        return view('index', [
            'title' => __('models/ad.ads'),
            'table' => livewire_table_name('ads-table')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param Company $company
     * @return View
     */
    public function create(Company $company): View
    {
        return $this->form(new Ad, 'create', $company);
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param Ad $ad
     * @return View
     */
    public function edit(Ad $ad): View
    {
        return $this->form($ad, 'edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Ad $ad
     * @param AdRequest $request
     * @return RedirectResponse
     */
    public function update(Ad $ad, AdRequest $request): RedirectResponse
    {
        return $this->apply($ad, $request);
    }

    public function store(AdRequest $request): RedirectResponse
    {
        return $this->apply(new Ad, $request);
    }

    /**
     * @param Ad $ad
     * @return RedirectResponse|Redirector
     */
    public function destroy(Ad $ad): RedirectResponse|Redirector
    {
        try {
            $ad->delete();

            // Delete current valid ad's offer
            if ($ad->offers()->valid()->exists()) {
                $ad->offers()->valid()->delete();
            }

            return redirect()
                ->route(auth_user_type() . '.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }
        catch (Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display resource's form
     * @param Ad $ad
     * @param string $action
     * @param Company|null $company
     * @return View
     */
    private function form(Ad $ad, string $action, ?Company $company = null): View
    {
        $company = $company ?? $ad->company;

        $types = AdType::options();

        // Get all company types
        $companyTypes = CompanyType::options();
        $existingCompanyTypes = Ad::query()
            ->select('company_type')
            ->where('company_id', $company->id)
            ->whereNull('expired_at')
            ->pluck('company_type')
            ->toArray();

        foreach ($existingCompanyTypes as $existingCompanyType) {
            unset($companyTypes[$existingCompanyType]);
        }

        $cities = City::query()->get();

        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads.update', ['ad' => $ad]),
            'create' => route(auth_user_type() . '.ads.store'),
            default => ''
        };
        $quit = route(auth_user_type() . '.ads.index');

        return view('partner.ads.form',[
            'company' => $company,
            'ad' => $ad,
            'types' => $types,
            'companyTypes' => $companyTypes,
            'cities' => $cities,
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
        try {
            $companyId = $request->input('company_id');
            $company = Company::query()->where('id', $companyId)->firstOrFail();
        } catch (Exception $e) {
            return redirect()->route(auth_user_type() . '.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.ad_company_not_found')]);
        }

        // What company is ad related to?
        if ($ad->company()->doesntExist()) {
            $ad->company()->associate($company);
        }
        // Standard, premium or gold type
        if ($request->input('type')) {
            $ad->type = $request->input('type');
        }

        $ad->title = $request->input('title');
        $ad->months_valid = $request->input('months_valid', 1);
        $ad->caption = $request->input('caption');

        $ad->company_type = $request->input('company_type');
        $ad->company_title = $request->input('company_title');
        $ad->company_address = $request->input('company_address');
        $ad->city_id = $request->input('city_id');
        $ad->company_website = $request->input('company_website');
        $ad->company_phone = $request->input('company_phone');
        $ad->company_mobile_phone = $request->input('company_mobile_phone');

        $companyLogo = $this->imageService->storeAdCompanyLogo($request, $ad);
        $ad->logo = $companyLogo;
        $adBanner = $this->imageService->storeAdBanner($request, $ad);
        $ad->banner = $adBanner;

        try {
            $ad->save();
            return redirect()->route(auth_user_type() . '.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
            return redirect()->route(auth_user_type() . '.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
