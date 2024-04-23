<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;

class AdPolicy
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
    public function view(User $user, Ad $ad): bool
    {
        $userOwnsCompany = auth()->user()->companies()->where('id', $ad->company_id)->exists();
        return is_admin() || (is_partner() && $userOwnsCompany);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $companies = auth()->user()->companies();
        // How many companies user own?
        $companiesCount = $companies->count();
        // How many companies user owns has no ads?
        $availableCompaniesCount = $companies->has('ad', '=' ,0)->count();

        return is_partner() || $companiesCount > 0 || $availableCompaniesCount > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ad): bool
    {
        return false;
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
