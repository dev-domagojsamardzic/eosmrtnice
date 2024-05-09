<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Offer::class);
    }

    /**
     * Display create form
     *
     * @param Ad $ad
     * @return View
     */
    public function create(Ad $ad): View
    {
        return $this->form(new Offer, $ad, 'create');
    }

    /**
     * Display resource form
     *
     * @param Offer $offer
     * @param Ad $ad
     * @param string $action
     * @return View
     */
    private function form(Offer $offer, Ad $ad, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.offers.update', ['offer' => $offer]),
            'create' => route(auth_user_type() . '.offers.store', ['ad' => $ad]),
            default => ''
        };

        return view(
            'admin.offers.form',
            [
                'offer' => $offer,
                'ad' => $ad,
                'action_name' => $action,
                'action' => $route,
                'quit' => url()->previous(),
            ]
        );
    }
}
