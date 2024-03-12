<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\User;

class PartnerPolicy
{
    /**
     * Determine whether the user can view any models.
     * CORRESPONDING TO index
     */
    public function viewAny(User $user): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can view the model.
     *  CORRESPONDING TO show
     */
    public function view(User $user, Partner $partner): bool
    {
        return is_admin() || $user->id === $partner->id;
    }

    /**
     * Determine whether the user can create models.
     *  CORRESPONDING TO create and store
     */
    public function create(User $user): bool
    {
        dd('Failing on ' . self::class . '::create');
    }

    /**
     * Determine whether the user can update the model.
     *  CORRESPONDING TO edit and update
     */
    public function update(User $user, Partner $partner): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can delete the model.
     *  CORRESPONDING TO destroy
     */
    public function delete(User $user, Partner $partner): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Partner $partner): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Partner $partner): bool
    {
        return is_admin();
    }
}
