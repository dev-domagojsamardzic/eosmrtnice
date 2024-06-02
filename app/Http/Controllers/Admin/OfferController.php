<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OfferRequest;
use App\Http\Requests\Admin\Offers\AdOfferRequest;
use App\Mail\OfferCreated;
use App\Models\Offer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

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
        return view('admin.offers.index');
    }

    /**
     * Show resource edit form
     *
     * @param Offer $offer
     * @return View
     */
    public function edit(Offer $offer): View
    {
        return $this->form($offer, 'edit');
    }

    /**
     * Update resource
     *
     * @param Offer $offer
     * @param OfferRequest $request
     * @return RedirectResponse
     */
    public function update(Offer $offer, OfferRequest $request): RedirectResponse
    {
        return $this->apply($offer, $request);
    }

    /**
     * Delete the resource
     *
     * @param Offer $offer
     * @return RedirectResponse|Redirector
     */
    public function destroy(Offer $offer): RedirectResponse|Redirector
    {
        try {
            $offer->delete();
            return redirect()
                ->route('admin.offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        }
        catch (Exception $e) {
            return redirect()
                ->route('admin.offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    public function send(Offer $offer): RedirectResponse
    {
        try {
            Mail::to($offer->company)->send(new OfferCreated($offer, true));

            $offer->sent_at = now();
            $offer->save();

            return redirect()->route('admin.offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display resource form
     *
     * @param Offer $offer
     * @param string $action
     * @return View
     */
    private function form(Offer $offer, string $action): View
    {
        $route = match ($action) {
            'edit' => route('admin.offers.update', ['offer' => $offer]),
            default => '',
        };

        return view('admin.offers.form', [
            'offer' => $offer,
            'action' => $route,
            'action_name' => $action,
            'quit' => route('admin.offers.index')
        ]);
    }

    /**
     * Apply changes on resource
     *
     * @param Offer $offer
     * @param OfferRequest $request
     * @return RedirectResponse
     */
    private function apply(Offer $offer, OfferRequest $request): RedirectResponse
    {
        $offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        try {
            $offer->save();

            if ($request->submit === "save_and_resend") {
                Mail::to($offer->company)->send(new OfferCreated($offer, true));

                $offer->sent_at = now();
                $offer->save();

                return redirect()->route('admin.offers.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('common/saved')]);
        } catch(Exception $e) {
            return redirect()
                ->route('admin.offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
