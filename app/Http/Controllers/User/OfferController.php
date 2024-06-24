<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Offer::class);
    }

    /**
     * Show all resources
     *
     * @return View
     */
    public function index(): View
    {
        return view('user.offers.index');
    }

    /**
     * Show resource
     * @param Offer $offer
     * @return View
     */
    public function show(Offer $offer): View
    {
        return view('user.offers.form', [
            'offer' => $offer,
            'action_name' => 'show',
            'back' => route('user.offers.index')
        ]);
    }

    /**
     * Download offer as PDF document
     *
     * @param Offer $offer
     * @return Response
     */
    public function download(Offer $offer): Response
    {
        return $offer->downloadPdf();
    }
}
