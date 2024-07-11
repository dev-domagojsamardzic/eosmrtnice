<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Offers\AdOfferRequest;
use App\Http\Controllers\Controller;
use App\Mail\AdsOfferCreated;
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
        return view('index', [
            'title' => __('admin.ads-offers'),
            'table' => livewire_table_name('ads-offers-table')
        ]);
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
     * Display edit form
     *
     * @param AdsOffer $ads_offer
     * @return View|RedirectResponse
     */
    public function edit(AdsOffer $ads_offer): View|RedirectResponse
    {
        return $this->form($ads_offer, null, 'edit');
    }

    /**
     * Store new resource
     *
     * @param AdsOffer $ads_offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    public function store(AdsOffer $ads_offer, AdOfferRequest $request): RedirectResponse
    {
        return $this->apply($ads_offer, $request, 'store');
    }

    /**
     * Update resource resource
     *
     * @param AdsOffer $ads_offer
     * @param AdOfferRequest $request
     * @return RedirectResponse
     */
    public function update(AdsOffer $ads_offer, AdOfferRequest $request): RedirectResponse
    {
        return $this->apply($ads_offer, $request, 'update');
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
     * @param AdsOffer $ads_offer
     * @return Response
     */
    public function download(AdsOffer $ads_offer): Response
    {
        return $ads_offer->downloadPdf();
    }

    /**
     * Display resource form
     *
     * @param AdsOffer $ads_offer
     * @param Ad|null $ad
     * @param string $action
     * @return View
     */
    private function form(AdsOffer $ads_offer, ?Ad $ad, string $action): View
    {
        $ad = $ad ?? $ads_offer->ad;

        $route = match($action) {
            'edit' => route(auth_user_type() . '.ads-offers.update', ['ads_offer' => $ads_offer]),
            'create' => route(auth_user_type() . '.ads-offers.store'),
            default => ''
        };

        return view(
            'admin.ads-offers.form',
            [
                'offer' => $ads_offer,
                'ad' => $ad,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.ads.index', ['ad' => $ad]),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param AdsOffer $ads_offer
     * @param AdOfferRequest $request
     * @param string $action
     * @return RedirectResponse
     */
    private function apply(AdsOffer $ads_offer, AdOfferRequest $request, string $action): RedirectResponse
    {
        if ($ads_offer->company()->doesntExist()) {
            $ads_offer->company()->associate($request->input('company_id'));
        }

        if ($ads_offer->ad()->doesntExist()) {
            $ads_offer->ad()->associate($request->input('ad_id'));
        }

        // TODO: SOLVE OFFER_NUMBER GENERATING
        $ads_offer->quantity = (int)$request->input('quantity');
        $ads_offer->price = (float)$request->input('price');

        $total = $ads_offer->price * $ads_offer->quantity;
        $taxes = ($total * ((float)config('app.tax_percentage') / 100));
        $ads_offer->total = $total;
        $ads_offer->taxes = $taxes;
        $ads_offer->net_total = $total - $taxes;
        $ads_offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $ads_offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        // Reset sent_at flag every time admin updates offer
        if ($action === 'update') {
            $ads_offer->sent_at = null;
        }

        try {
            $ads_offer->save();

            if ($request->submit === 'save_and_send') {

                if (!$ads_offer->company?->email) {
                    return redirect()
                        ->route('admin.ads-offers.index')
                        ->with('alert', ['class' => 'danger', 'message' => __('models/offer.company_email_not_set')]);
                }

                Mail::to($ads_offer->company)->queue(new AdsOfferCreated($ads_offer));

                $ads_offer->sent_at = now();
                $ads_offer->save();

                return redirect()->route('admin.ads-offers.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.ads-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.ads-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
