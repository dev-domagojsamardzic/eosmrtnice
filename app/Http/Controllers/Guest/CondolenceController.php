<?php

namespace App\Http\Controllers\Guest;

use App\Enums\CondolenceMotive;
use App\Enums\CondolencePackageAddon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CondolenceRequest;
use App\Models\Condolence;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CondolenceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $addons = CondolencePackageAddon::options();
        $motives = CondolenceMotive::options();

        return view('guest/condolences.form', [
            'addons' => $addons,
            'motives' => $motives,
        ]);
    }

    /**
     * Store new resource
     * @param CondolenceRequest $request
     * @return RedirectResponse
     */
    public function store(CondolenceRequest $request): RedirectResponse
    {
        $condolence = new Condolence();
        $condolence->motive = $request->input('motive');
        $condolence->message = trim($request->input('message'), " \r\n\t");
        $condolence->recipient_full_name = $request->input('recipient_full_name');
        $condolence->recipient_address = trim($request->input('recipient_address'), " \r\n\t");
        $condolence->sender_full_name = $request->input('sender_full_name');
        $condolence->sender_email = $request->input('sender_email');
        $condolence->sender_phone = $request->input('sender_phone');
        $condolence->sender_address = trim($request->input('sender_address'), " \r\n\t");
        $condolence->sender_additional_info = trim($request->input('sender_additional_info'), " \r\n\t");
        $condolence->package_addon = $request->input('package_addon', []);

        try {
            $condolence->save();
            return redirect()->back()->with('alert', ['class' => 'success', 'message' => 'Uspješno ste poslali narudžbu za paket sućuti. Javit ćemo Vam se u najkraćem mogućem roku.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
