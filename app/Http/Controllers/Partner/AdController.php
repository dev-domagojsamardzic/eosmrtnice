<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\AdRequest;
use App\Models\Ad;
use App\Models\Company;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\RedirectResponse;
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
     * @param Ad $ad
     * @return RedirectResponse|Redirector
     */
    public function destroy(Ad $ad): RedirectResponse|Redirector
    {
        try {
            $ad->delete();
            return redirect()
                ->route('admin.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }
        catch (Exception $e) {
            return redirect()
                ->route('admin.ads.index')
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

        $companyLogo = $this->imageService->storeCompanyLogo($request, $company);
        $company->logo = $companyLogo;
        $company->save();

        if ($ad->company()->doesntExist()) {
            $ad->company()->associate($company);
        }

        if ($request->input('type')) {
            $ad->type = $request->input('type');
        }

        $ad->months_valid = $request->input('months_valid', 1);
        $ad->caption = $request->input('caption');

        $adBanner = $this->imageService->storeAdBanner($request, $ad);
        $ad->banner = $adBanner;

        try {
            $ad->save();
            return redirect()->route('admin.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
            return redirect()->route('admin.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
