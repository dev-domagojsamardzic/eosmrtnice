<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Http\Controllers\Admin\OfferController;
use App\Http\Requests\Admin\Offers\AdOfferRequest;
use App\Models\Ad;
use App\Models\Offer;
use App\Models\Offerable;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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
                'quit' => route(auth_user_type() . '.ads.index', ['ad' => $ad]),
            ]
        );
    }

    /**
     * Store new resource
     *
     * @param Offer $offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    public function store(Offer $offer, AdOfferRequest $request): RedirectResponse
    {
        return $this->apply($offer, $request);
    }

    /**
     * Apply changes on resource
     * @param Offer $offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    protected function apply(Offer $offer, AdOfferRequest $request): RedirectResponse
    {
        if (!$offer->exists) {
            $offer->number = now()->timestamp . '-' . now()->format('m/Y');
        }

        $offer->company()->associate($request->input('company_id'));
        $total = (float)$request->input('quantity') * $request->input('price');
        $taxes = (float)($total * (config('app.tax_percentage') / 100));
        $offer->total = $total;
        $offer->taxes = $taxes;
        $offer->net_total = $total - $taxes;
        $offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        try{
            $offer->save();

            $offerable = new Offerable();
            $offerable->offer_id = $offer->id;
            $offerable->offerable_type = $request->input('offerable_type');
            $offerable->offerable_id = $request->input('offerable_id');
            $offerable->quantity = $request->input('quantity');
            $offerable->price = $request->input('price');
            $offerable->save();
            return redirect()->route('admin.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        }catch (\Exception $e) {
            return redirect()
                ->route('admin.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

}
