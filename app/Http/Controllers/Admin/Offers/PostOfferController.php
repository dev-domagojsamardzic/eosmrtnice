<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Http\Controllers\Admin\OfferController;
use App\Http\Requests\Admin\Offers\PostOfferRequest;
use App\Mail\OfferCreated;
use App\Models\Offer;
use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PostOfferController extends OfferController
{
    /**
     * Display create form
     *
     * @param Post $post
     * @return View|RedirectResponse
     */
    public function create(Post $post): View|RedirectResponse
    {
        return $this->form(new Offer, $post, 'create');
    }

    public function store(Offer $offer, PostOfferRequest $request): RedirectResponse
    {
        return $this->apply($offer, $request);
    }

    /**
     * Display resource form
     *
     * @param Offer $offer
     * @param Post $post
     * @param string $action
     * @return View
     */
    protected function form(Offer $offer, Post $post, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.posts.offers.update', ['offer' => $offer]),
            'create' => route(auth_user_type() . '.posts.offers.store', ['post' => $post]),
            default => ''
        };

        return view(
            'admin.posts.offers.form',
            [
                'offer' => $offer,
                'post' => $post,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.posts.index', ['post' => $post]),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param Offer $offer
     * @param PostOfferRequest $request
     * @return RedirectResponse
     */
    protected function apply(Offer $offer, PostOfferRequest $request): RedirectResponse
    {
        $offer->user()->associate($request->input('user_id'));
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
                'offerable_type' => Post::class,
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
            ]);

            if ($request->submit === 'save_and_send') {

                Mail::to($offer->user)->send(new OfferCreated($offer));

                $offer->sent_at = now();
                $offer->save();

                return redirect()->route('admin.posts.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.posts.index')
                ->with('alert', ['class' => 'success', 'message' => __('common/saved')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
