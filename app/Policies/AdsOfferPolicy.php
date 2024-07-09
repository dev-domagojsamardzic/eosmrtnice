<?php

namespace App\Policies;

use App\Models\Offer;
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
    public function view(User $user, Offer $offer): bool
    {
        return is_admin() ||
            (is_partner() && $offer->company->user->id === $user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer): bool
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
