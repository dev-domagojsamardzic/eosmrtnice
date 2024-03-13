<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display all companies
     */
    public function index(): View
    {
        return view('admin.companies.index');
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
     * Display resource's form
     * @param Company $company
     * @param string $action
     * @return View
     */
    private function form(Company $company, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.companies.update', ['company' => $company]),
            'create' => route(auth_user_type() . '.companies.store'),
            default => ''
        };

        return view(
            'admin.companies.form', [
                'company' => $company,
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
        $company->title = $request->input('title');
        $company->address = $request->input('address');
        $company->town = $request->input('town');
        $company->zipcode = $request->input('zipcode');
        $company->oib = $request->input('oib');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->mobile_phone = $request->input('mobile_phone');
        $company->active = $request->boolean('active');
        $company->save();

        return redirect()->route('admin.companies.index');
    }
}
