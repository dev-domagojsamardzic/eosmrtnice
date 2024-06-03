<?php

namespace App\Http\Controllers\Partner;

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
        return view('partner.offers.index');
    }

    public function show(Offer $offer): View
    {
        return view('partner.offers.form', [
            'offer' => $offer,
            'action_name' => 'show',
            'back' => route('partner.offers.index')
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
