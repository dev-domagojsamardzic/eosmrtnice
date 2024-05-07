<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use App\Traits\AuthorizationPolicyHelper;

class AdPolicy
{
    use AuthorizationPolicyHelper;
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
    public function view(User $user, Ad $ad): bool
    {
        return is_admin() || (is_partner() && $this->userOwnsAdRelatedCompany($user, $ad));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return is_partner() &&
            $this->userOwnsAtLeastOneCompany($user) &&
            $this->userOwnsCompaniesAvailableForAds($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ad): bool
    {
        return is_admin() || (is_partner() && $this->userOwnsAdRelatedCompany($user, $ad));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ad $ad): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ad $ad): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ad $ad): bool
    {
        return false;
    }
}
