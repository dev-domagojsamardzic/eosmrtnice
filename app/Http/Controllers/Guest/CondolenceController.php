<?php

namespace App\Http\Controllers\Guest;

use App\Enums\CondolenceMotive;
use App\Enums\CondolencePackageAddon;
use App\Http\Controllers\Controller;
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
}
