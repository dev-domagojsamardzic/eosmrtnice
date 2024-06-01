<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Offer::class);
    }

    /**
     * Display all offers
     */
    public function index(): View
    {
        return view('admin.offers.index');
    }
}
