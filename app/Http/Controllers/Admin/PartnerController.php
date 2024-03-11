<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
     * Show partner edit form
     * @param User $partner
     * @return View
     */
    public function edit(User $partner): View
    {
        return $this->form($partner, 'edit');
    }

    /**
     * @param User $partner
     * @param PartnerRequest $request
     * @return RedirectResponse
     */
    public function update(User $partner, PartnerRequest $request): RedirectResponse
    {
        return $this->apply($partner, $request);
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
            'edit' => route(auth_user_type() . '.partners.update', ['partner' => $partner]),
            'create' => route(auth_user_type() . '.partners.store'),
            default => ''
        };

        return view(
            'admin.partners.form', [
                'partner' => $partner,
                'action_name' => $action,
                'route' => $route,
                'quit' => route(auth_user_type() . '.partners.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param User $partner
     * @param PartnerRequest $request
     * @return RedirectResponse
     */
    private function apply(User $partner, PartnerRequest $request): RedirectResponse
    {
        $partner->first_name = $request->input('first_name');
        $partner->last_name = $request->input('last_name');
        $partner->sex = $request->input('sex');
        $partner->email = $request->input('email');
        $partner->active = $request->boolean('active');
        $partner->save();

        return redirect()->route('admin.partners.index');
    }
}
