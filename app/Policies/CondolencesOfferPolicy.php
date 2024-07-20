<?php

namespace App\Policies;

use App\Models\CondolencesOffer;
use App\Models\User;

class CondolencesOfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CondolencesOffer $condolencesOffer): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CondolencesOffer $condolencesOffer): bool
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
