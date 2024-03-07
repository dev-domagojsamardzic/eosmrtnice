<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display all partners
     */
    public function index(): View
    {
        return view('partner.index');
    }
}
