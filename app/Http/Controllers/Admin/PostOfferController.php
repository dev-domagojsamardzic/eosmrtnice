<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offers\PostOfferRequest;
use App\Mail\PostsOfferCreated;
use App\Models\Post;
use App\Models\PostsOffer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PostOfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PostsOffer::class);
    }

    /**
     * Show all resources
     * @return View
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.posts-offers'),
            'table' => livewire_table_name('posts-offers-table')
        ]);
    }

    /**
     * Display create form
     *
     * @param Post $post
     * @return View|RedirectResponse
     */
    public function create(Post $post): View|RedirectResponse
    {
        if (!Gate::allows('create-post-offer', [$post])) {
            return redirect()->route('admin.posts.show', ['post' => $post])
                ->with('alert', ['class' => 'danger', 'message' => __('models/offer.messages.offer_for_posts_exists')]);
        }

        return $this->form(new PostsOffer, $post, 'create');
    }

    /**
     * Display edit form
     *
     * @param PostsOffer $posts_offer
     * @return View
     */
    public function edit(PostsOffer $posts_offer): View
    {
        return $this->form($posts_offer, null, 'edit');
    }

    /**
     * Store new resource
     *
     * @param PostsOffer $posts_offer
     * @param PostOfferRequest $request
     * @return RedirectResponse
     */
    public function store(PostsOffer $posts_offer, PostOfferRequest $request): RedirectResponse
    {
        return $this->apply($posts_offer, $request, 'store');
    }

    /**
     * Update resource
     *
     * @param PostsOffer $posts_offer
     * @param PostOfferRequest $request
     * @return RedirectResponse
     */
    public function update(PostsOffer $posts_offer, PostOfferRequest $request): RedirectResponse
    {
        return $this->apply($posts_offer, $request, 'update');
    }

    /**
     * Send an offer
     *
     * @param PostsOffer $posts_offer
     * @return RedirectResponse
     */
    public function send(PostsOffer $posts_offer): RedirectResponse
    {
        $receiver = $posts_offer->user?->email;

        if (!$receiver) {
            return redirect()
                ->route('admin.posts-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('models/offer.user_email_not_set')]);
        }

        try {
            Mail::to($receiver)->queue(new PostsOfferCreated($posts_offer));

            $posts_offer->sent_at = now();
            $posts_offer->save();

            return redirect()->route('admin.posts-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.posts-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Download offer as PDF document
     *
     * @param PostsOffer $posts_offer
     * @return Response
     */
    public function download(PostsOffer $posts_offer): Response
    {
        return $posts_offer->downloadPdf();
    }

    /**
     * Display resource form
     *
     * @param PostsOffer $posts_offer
     * @param Post|null $post
     * @param string $action
     * @return View
     */
    protected function form(PostsOffer $posts_offer, ?Post $post, string $action): View
    {
        $post = $post ?? $posts_offer->post;

        $route = match($action) {
            'edit' => route(auth_user_type() . '.posts-offers.update', ['posts_offer' => $posts_offer]),
            'create' => route(auth_user_type() . '.posts-offers.store'),
            default => ''
        };

        return view(
            'admin.posts-offers.form',
            [
                'offer' => $posts_offer,
                'post' => $post,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.posts.index', ['post' => $post]),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param PostsOffer $posts_offer
     * @param PostOfferRequest $request
     * @param string $action
     * @return RedirectResponse
     */
    protected function apply(PostsOffer $posts_offer, PostOfferRequest $request, string $action): RedirectResponse
    {
        if ($posts_offer->user()->doesntExist()) {
            $posts_offer->user()->associate($request->input('user_id'));
        }

        if ($posts_offer->post()->doesntExist()) {
            $posts_offer->post()->associate($request->input('post_id'));
        }

        // TODO: SOLVE OFFER_NUMBER GENERATING
        $posts_offer->quantity = (int)$request->input('quantity');
        $posts_offer->price = (float)$request->input('price');

        $total = $posts_offer->price * $posts_offer->quantity;
        $taxes = ($total * ((float)config('app.tax_percentage') / 100));
        $posts_offer->total = $total;
        $posts_offer->taxes = $taxes;
        $posts_offer->net_total = $total - $taxes;
        $posts_offer->valid_from = Carbon::parse($request->input('valid_from'))->format('Y-m-d');
        $posts_offer->valid_until = Carbon::parse($request->input('valid_until'))->format('Y-m-d');

        // Reset sent_at flag every time admin updates offer
        if ($action === 'update') {
            $posts_offer->sent_at = null;
        }

        try {
            $posts_offer->save();

            if ($request->submit === 'save_and_send') {

                if (!$posts_offer->user?->email) {
                    return redirect()
                        ->route('admin.posts-offers.index')
                        ->with('alert', ['class' => 'danger', 'message' => __('models/offer.user_email_not_set')]);
                }

                Mail::to($posts_offer->user)->queue(new PostsOfferCreated($posts_offer));

                $posts_offer->sent_at = now();
                $posts_offer->save();

                return redirect()->route('admin.posts-offers.index')
                    ->with('alert', ['class' => 'success', 'message' => __('models/offer.messages.offer_sent')]);
            }

            return redirect()->route('admin.posts-offers.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch (Exception $e) {
            return redirect()
                ->route('admin.posts-offers.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
