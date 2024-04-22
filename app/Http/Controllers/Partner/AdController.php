<?php

namespace App\Http\Controllers\Partner;

use App\Enums\AdType;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('partner.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return $this->form(new Ad, 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        //
    }

    /**
     * Display resource's form
     * @param Ad $ad
     * @param string $action
     * @return View
     */
    private function form(Ad $ad, string $action): View
    {
        $types = AdType::options();

        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads.update', ['ad' => $ad]),
            'create' => route(auth_user_type() . '.ads.store'),
            default => ''
        };

        return view('partner.ads.form',[
            'ad' => $ad,
            'types' => $types,
            'action_name' => $action,
            'action' => $route,
        ]);
    }
}
