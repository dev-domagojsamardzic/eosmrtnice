<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Offers\AdOfferRequest;
use App\Http\Controllers\Controller;
use App\Mail\AdsOfferCreated;
use App\Mail\OfferCreated;
use App\Models\Ad;
use App\Models\AdsOffer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdsOfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(AdsOffer::class);
    }

    /**
     * Show all resources
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.offers.index');
    }

    /**
     * Display create form
     *
     * @param Ad $ad
     * @return View|RedirectResponse
     */
    public function create(Ad $ad): View|RedirectResponse
    {
        if (!Gate::allows('create-ad-offer', [$ad])) {
            return redirect()->route('admin.ads.show', ['ad' => $ad])
                ->with('alert', ['class' => 'danger', 'message' => __('models/offer.messages.offer_for_ad_exists')]);
        }

        return $this->form(new AdsOffer, $ad, 'create');
    }

    /**
     * Store new resource
     *
     * @param AdsOffer $offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    public function store(AdsOffer $offer, AdOfferRequest $request): RedirectResponse
    {
        return $this->apply($offer, $request);
    }

    /**
     * Send an offer
     *
     * @param AdsOffer $ads_offer
     * @return RedirectResponse
     */
    public function send(AdsOffer $ads_offer): RedirectResponse
    {
        $receiver = $ads_offer->company?->email;

        if (!$receiver) {
            return redirect()
                ->route('admin.ads-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('models/offer.company_email_not_set')]);
        }

        try {
            Mail::to($receiver)->queue(new AdsOfferCreated($ads_offer));

            $ads_offer->sent_at = now();
            $ads_offer->save();

            return redirect()->route('admin.ads-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.ads-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Download offer as PDF document
     *
     * @param AdsOffer $offer
     * @return Response
     */
    public function download(AdsOffer $offer): Response
    {
        return $offer->downloadPdf();
    }

    /**
     * Display resource form
     *
     * @param AdsOffer $offer
     * @param Ad $ad
     * @param string $action
     * @return View
     */
    private function form(AdsOffer $offer, Ad $ad, string $action): View
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
     * Apply changes on resource
     * @param AdsOffer $offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    private function apply(AdsOffer $offer, AdOfferRequest $request): RedirectResponse
    {
        $offer->company()->associate($request->input('company_id'));
        $total = (float)$request->input('quantity') * $request->input('price');
        $taxes = (float)($total * (config('app.tax_percentage') / 100));
        $offer->total = $total;
        $offer->taxes = $taxes;
        $offer->net_total = $total - $taxes;
        $offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        try {
            $offer->save();

            $offer->offerables()->create([
                'offerable_id' => $request->input('offerable_id'),
                'offerable_type' => Ad::class,
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
            ]);

            if ($request->submit === 'save_and_send') {

                Mail::to($offer->company)->queue(new OfferCreated($offer));

                $offer->sent_at = now();
                $offer->save();

                return redirect()->route('admin.ads.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.ads.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.ads.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
