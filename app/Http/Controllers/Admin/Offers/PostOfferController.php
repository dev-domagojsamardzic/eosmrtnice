<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Http\Controllers\Admin\OfferController;
use App\Models\Offer;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
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
}
