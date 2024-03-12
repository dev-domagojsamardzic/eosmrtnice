<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
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
     * @param Partner $partner
     * @return View
     */
    public function edit(Partner $partner): View
    {
        return $this->form($partner, 'edit');
    }

    /**
     * @param Partner $partner
     * @param PartnerRequest $request
     * @return RedirectResponse
     */
    public function update(Partner $partner, PartnerRequest $request): RedirectResponse
    {
        return $this->apply($partner, $request);
    }

    /**
     * Display resource's form
     * @param Partner $partner
     * @param string $action
     * @return View
     */
    private function form(Partner $partner, string $action): View
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
                'action' => $route,
                'quit' => route(auth_user_type() . '.partners.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param Partner $partner
     * @param PartnerRequest $request
     * @return RedirectResponse
     */
    private function apply(Partner $partner, PartnerRequest $request): RedirectResponse
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
