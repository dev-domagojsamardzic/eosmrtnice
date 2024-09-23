<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdTypeRequest;
use App\Models\AdType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class AdTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.ad_types'),
            'table' => livewire_table_name('ad-types-table'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->form(new AdType, 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdTypeRequest $request): RedirectResponse
    {
        return $this->apply(new AdType, $request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdType $adType): View
    {
        return $this->form($adType, 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdTypeRequest $request, AdType $adType): RedirectResponse|Redirector
    {
        return $this->apply($adType, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdType $adType): RedirectResponse|Redirector
    {
        try {
            $adType->delete();
            return redirect()->route(auth_user_type().'.ad-types.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        } catch (\Exception $e) {
            return redirect()->route(auth_user_type().'.ad-types.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display create/edit resource form
     * @param AdType $adType
     * @param string $action
     * @return View
     */
    protected function form(AdType $adType, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.ad-types.update', ['ad_type' => $adType]),
            'create' => route(auth_user_type() . '.ad-types.store'),
            default => ''
        };

        return view('admin.ad-types.form', [
            'adType' => $adType,
            'action_name' => $action,
            'action' => $route,
            'quit' => route(auth_user_type() . '.ad-types.index'),
        ]);
    }

    /**
     * Apply changes on resource
     * @param AdType $adType
     * @param AdTypeRequest $request
     * @return RedirectResponse
     */
    protected function apply(AdType $adType, AdTypeRequest $request): RedirectResponse
    {
        $adType->title = $request->input('title');
        $adType->price = $request->input('price');
        $adType->duration_months = $request->input('duration_months');

        try{
            $adType->save();
            return redirect()->route(auth_user_type() . '.ad-types.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.ad-types.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
