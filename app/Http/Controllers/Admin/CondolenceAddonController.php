<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CondolenceAddonRequest;
use App\Models\CondolenceAddon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class CondolenceAddonController extends Controller
{
    /**
     * Display all resources
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.condolence_addons'),
            'table' => livewire_table_name('condolence-addons-table'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->form(new CondolenceAddon, 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CondolenceAddonRequest $request): RedirectResponse
    {
        return $this->apply(new CondolenceAddon, $request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CondolenceAddon $condolence_addon): View
    {
        return $this->form($condolence_addon, 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CondolenceAddonRequest $request, CondolenceAddon $condolenceAddon): RedirectResponse
    {
        return $this->apply($condolenceAddon, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CondolenceAddon $condolenceAddon): RedirectResponse|Redirector
    {
        try {
            $condolenceAddon->delete();
            return redirect()->route(auth_user_type().'.condolence-addons.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        } catch (\Exception $e) {
            return redirect()->route(auth_user_type().'.condolence-addons.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display create/edit resource form
     * @param CondolenceAddon $condolenceAddon
     * @param string $action
     * @return View
     */
    protected function form(CondolenceAddon $condolenceAddon, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.condolence-addons.update', ['condolence_addon' => $condolenceAddon]),
            'create' => route(auth_user_type() . '.condolence-addons.store'),
            default => ''
        };

        return view('admin.condolence-addons.form', [
            'addon' => $condolenceAddon,
            'action_name' => $action,
            'action' => $route,
            'quit' => route(auth_user_type() . '.condolence-addons.index'),
        ]);
    }

    /**
     * Apply changes on resource
     * @param CondolenceAddon $condolenceAddon
     * @param CondolenceAddonRequest $request
     * @return RedirectResponse
     */
    protected function apply(CondolenceAddon $condolenceAddon, CondolenceAddonRequest $request): RedirectResponse
    {
        $condolenceAddon->title = $request->input('title');
        $condolenceAddon->price = $request->input('price');

        try{
            $condolenceAddon->save();
            return redirect()->route(auth_user_type() . '.condolence-addons.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.condolence-addons.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
