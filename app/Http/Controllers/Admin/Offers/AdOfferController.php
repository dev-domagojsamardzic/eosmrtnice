<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Http\Controllers\Admin\OfferController;
use App\Models\Ad;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdOfferController extends OfferController
{

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
    protected function form(Offer $offer, Ad $ad, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads.offers.update', ['offer' => $offer]),
            'create' => route(auth_user_type() . '.ads.offers.store', ['ad' => $ad]),
            default => ''
        };

        return view(
            'admin.ads.offers.form',
            [
                'offer' => $offer,
                'ad' => $ad,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.ads.offers.index', ['ad' => $ad]),
            ]
        );
    }

    /**
     * Store new resource
     *
     * @param Offer $offer
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Offer $offer, Request $request): RedirectResponse
    {
        return $this->apply($offer, $request);
    }

    /**
     * Apply changes on resource
     * @param Offer $offer
     * @param Request $request
     * @return RedirectResponse
     */
    protected function apply(Offer $offer, Request $request): RedirectResponse
    {
        dd($offer, $request);
        try{
            $offer->save();
            return redirect()->route('admin.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        }catch (\Exception $e) {
            return redirect()
                ->route('admin.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

}
