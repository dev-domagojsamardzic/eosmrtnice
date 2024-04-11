<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class PartnerController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Partner::class);
    }

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
     * Update resource
     * @param Partner $partner
     * @param PartnerRequest $request
     * @return RedirectResponse
     */
    public function update(Partner $partner, PartnerRequest $request): RedirectResponse
    {
        return $this->apply($partner, $request);
    }

    /**
     * Delete resource
     * @param Partner $partner
     * @return RedirectResponse|Redirector
     */
    public function destroy(Partner $partner): RedirectResponse|Redirector
    {
        try{
            $partner->delete();
            return redirect()->route('admin.partners.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }catch (\Exception $e) {
            return redirect()
                ->route('admin.partners.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
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
        $partner->gender = $request->input('gender');
        $partner->email = $request->input('email');
        $partner->active = $request->boolean('active');

        try{
            $partner->save();
            return redirect()->route('admin.partners.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route('admin.partners.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
