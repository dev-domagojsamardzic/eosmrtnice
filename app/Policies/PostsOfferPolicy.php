<?php

namespace App\Policies;

use App\Models\PostsOffer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostsOfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return is_admin() || is_member();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostsOffer $postsOffer): bool
    {
        return is_admin() ||
            (is_member() && $postsOffer->user_id === $user->id && !$postsOffer->sent_at);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostsOffer $postsOffer): bool
    {
        return is_admin();
    }
}
