<?php

namespace App\Http\Controllers\Partner;

use App\Enums\CompanyType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\CompanyRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\County;
use App\Models\Partner;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class CompanyController extends Controller
{
    public function __construct(protected ImageService $imageService)
    {
        $this->authorizeResource(Company::class);
    }

    /**
     * Display all companies
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.companies'),
            'table' => livewire_table_name('companies-table'),
        ]);
    }

    /**
     * Show company create form
     * @return View
     */
    public function create(): View
    {
        return $this->form(new Company, 'create');
    }

    /**
     * Show company edit form
     * @param Company $company
     * @return View
     */
    public function edit(Company $company): View
    {
        return $this->form($company, 'edit');
    }

    /**
     * Store new resource
     * @param CompanyRequest $request
     * @return RedirectResponse
     */
    public function store(CompanyRequest $request): RedirectResponse
    {
        return $this->apply(new Company, $request);
    }

    /**
     * Update resource
     * @param Company $company
     * @param CompanyRequest $request
     * @return RedirectResponse
     */
    public function update(Company $company, CompanyRequest $request): RedirectResponse
    {
        return $this->apply($company, $request);
    }

    /**
     * Delete resource
     * @param Company $company
     * @return RedirectResponse|Redirector
     */
    public function destroy(Company $company): RedirectResponse|Redirector
    {
        try {
            $company->delete();
            return redirect()->route(auth_user_type() . '.companies.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        } catch (\Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.companies.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display resource's form
     * @param Company $company
     * @param string $action
     * @return View
     */
    private function form(Company $company, string $action): View
    {
        $types = CompanyType::options();
        $counties = County::query()->orderBy('title')->get();
        $cities = City::query()->orderBy('title')->get();

        $partners = null;
        if (is_admin()) {
            $partners = Partner::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();
        }

        $route = match($action) {
            'edit' => route(auth_user_type() . '.companies.update', ['company' => $company]),
            'create' => route(auth_user_type() . '.companies.store'),
            default => ''
        };

        return view(
            'partner.companies.form', [
                'company' => $company,
                'types' => $types,
                'counties' => $counties,
                'cities' => $cities,
                'partners' => $partners,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.companies.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param Company $company
     * @param CompanyRequest $request
     * @return RedirectResponse
     */
    private function apply(Company $company, CompanyRequest $request): RedirectResponse
    {
        $companyLogo = $this->imageService->storeCompanyLogo($request, $company);
        $company->logo = $companyLogo;

        if (is_admin()) {
            $company->user()->associate($request->input('user_id'));
        }
        if (is_partner()) {
            $company->user()->associate(auth()->user());
        }

        $company->type = $request->input('type');
        $company->title = $request->input('title');
        $company->address = $request->input('address');
        $company->town = $request->input('town');
        $company->zipcode = $request->input('zipcode');
        $company->oib = $request->input('oib');
        $company->city()->associate($request->input('city_id'));
        $company->county()->associate($request->input('county_id'));
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->mobile_phone = $request->input('mobile_phone');
        $company->active = $request->boolean('active');
        $company->website = $request->input('website');

        try{
            $company->save();
            return redirect()->route(auth_user_type() . '.companies.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.companies.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
