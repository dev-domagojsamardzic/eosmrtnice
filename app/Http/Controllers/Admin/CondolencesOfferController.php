<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offers\CondolenceOfferRequest;
use App\Mail\AdsOfferCreated;
use App\Mail\CondolencesOfferCreated;
use App\Models\Condolence;
use App\Models\CondolencesOffer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CondolencesOfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CondolencesOffer::class);
    }

    /**
     * Show all resources
     *
     * @return View
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.condolences-offers'),
            'table' => livewire_table_name('condolences-offers-table')
        ]);
    }

    /**
     * Display create form
     *
     * @param Condolence $condolence
     * @return View|RedirectResponse
     */
    public function create(Condolence $condolence): View|RedirectResponse
    {
        return $this->form(new CondolencesOffer, $condolence, 'create');
    }

    /**
     * Display edit form
     *
     * @param CondolencesOffer $condolences_offer
     * @return View|RedirectResponse
     */
    public function edit(CondolencesOffer $condolences_offer): View|RedirectResponse
    {
        return $this->form($condolences_offer, null, 'edit');
    }

    /**
     * Store new resource
     *
     * @param CondolencesOffer $condolences_offer
     * @param CondolenceOfferRequest $request
     * @return RedirectResponse
     */
    public function store(CondolencesOffer $condolences_offer, CondolenceOfferRequest $request): RedirectResponse
    {
        return $this->apply($condolences_offer, $request, 'store');
    }

    /**
     * Update resource resource
     *
     * @param CondolencesOffer $condolences_offer
     * @param CondolenceOfferRequest $request
     * @return RedirectResponse
     */
    public function update(CondolencesOffer $condolences_offer, CondolenceOfferRequest $request): RedirectResponse
    {
        return $this->apply($condolences_offer, $request, 'update');
    }

    /**
     * Send an offer
     *
     * @param CondolencesOffer $condolences_offer
     * @return RedirectResponse
     */
    public function send(CondolencesOffer $condolences_offer): RedirectResponse
    {
        $receiver = $condolences_offer->condolence?->sender_email;

        if (!$receiver) {
            return redirect()
                ->route('admin.condolences-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('models/offer.sender_email_not_set')]);
        }

        try {
            Mail::to($receiver)->queue(new CondolencesOfferCreated($condolences_offer));

            $condolences_offer->sent_at = now();
            $condolences_offer->save();

            return redirect()->route('admin.condolences-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.condolences-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Download offer as PDF document
     *
     * @param CondolencesOffer $condolences_offer
     * @return Response
     */
    public function download(CondolencesOffer $condolences_offer): Response
    {
        return $condolences_offer->downloadPdf();
    }

    /**
     * Display resource form
     *
     * @param CondolencesOffer $condolences_offer
     * @param Condolence|null $condolence
     * @param string $action
     * @return View
     */
    private function form(CondolencesOffer $condolences_offer, ?Condolence $condolence, string $action): View
    {
        $condolence = $condolence ?? $condolences_offer->condolence;

        $route = match($action) {
            'edit' => route('admin.condolences-offers.update', ['condolences_offer' => $condolences_offer]),
            'create' => route('admin.condolences-offers.store'),
            default => ''
        };

        return view(
            'admin.condolences-offers.form',
            [
                'offer' => $condolences_offer,
                'condolence' => $condolence,
                'action_name' => $action,
                'action' => $route,
                'quit' => route('admin.condolences.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param CondolencesOffer $condolences_offer
     * @param CondolenceOfferRequest $request
     * @param string $action
     * @return RedirectResponse
     */
    private function apply(CondolencesOffer $condolences_offer, CondolenceOfferRequest $request, string $action): RedirectResponse
    {
        if ($condolences_offer->condolence()->doesntExist()) {
            $condolences_offer->condolence()->associate($request->input('condolence_id'));
        }

        $condolences_offer->quantity = (int)$request->input('quantity');
        $condolences_offer->price = (float)$request->input('price');

        $total = (float)$condolences_offer->price * (int)$condolences_offer->quantity;

        $condolences_offer->total = $total;
        $condolences_offer->taxes = get_tax_value($total);
        $condolences_offer->net_total = get_nett_amount($total);
        $condolences_offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $condolences_offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        // Reset sent_at flag every time admin updates offer
        if ($action === 'update') {
            $condolences_offer->sent_at = null;
        }

        try {
            $condolences_offer->save();

            if ($request->submit === 'save_and_send') {

                if (!$condolences_offer->condolence?->sender_email) {
                    return redirect()
                        ->route('admin.ads-offers.index')
                        ->with('alert', ['class' => 'danger', 'message' => __('models/condolence.sender_email_not_set')]);
                }

                Mail::to($condolences_offer->condolence?->sender_email)->queue(new CondolencesOfferCreated($condolences_offer));

                $condolences_offer->sent_at = now();
                $condolences_offer->save();

                return redirect()->route('admin.condolences-offers.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.condolences-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.condolences-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
