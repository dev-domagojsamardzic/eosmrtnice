<?php

namespace App\Policies;

use App\Models\Deceased;
use App\Models\User;

class DeceasedPolicy
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
    public function view(User $user, Deceased $deceased): bool
    {
        return is_admin() || (is_member() && $deceased->user_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return is_member();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Deceased $deceased): bool
    {
        return is_admin() || (is_member() && $deceased->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Deceased $deceased): bool
    {
        return is_admin() || (is_member() && $deceased->user_id === $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Deceased $deceased): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Deceased $deceased): bool
    {
        return is_admin();
    }
}
