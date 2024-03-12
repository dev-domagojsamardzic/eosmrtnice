<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
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
}
