<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display all partners
     */
    public function index(): View
    {
        return view('admin.partners.index');
    }

    /**
     * @param User $partner
     * @return View
     */
    public function show(User $partner): View
    {
        return view('admin.partners.form', ['partner' => $partner]);
    }

    /**
     * Show partner edit form
     * @param User $partner
     * @return View
     */
    public function edit(User $partner): View
    {
        return $this->form($partner, 'edit');
    }

    public function update(User $partner, Request $request): RedirectResponse
    {

    }

    /**
     * Display resource's form
     * @param User $partner
     * @param string $action
     * @return View
     */
    private function form(User $partner, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.partners.edit', ['partner' => $partner]),
            'create' => route(auth_user_type() . '.partners.create'),
            default => ''
        };

        return view('admin.partners.form', ['partner' => $partner, 'action' => $action, 'route' => $route]);
    }
}
