<?php

namespace App\Policies;

use App\Models\AdsOffer;
use App\Models\User;

class AdsOfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return is_admin() || is_partner();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdsOffer $adsOffer): bool
    {
        return is_admin() ||
            (is_partner() && $adsOffer->company->user->id === $user->id && !$adsOffer->sent_at);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdsOffer $adsOffer): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        return is_admin();
    }
}
