<?php

namespace App\Policies;

use App\Models\BasicUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BasicUserPolicy
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
    public function view(User $user, BasicUser $basicUser): bool
    {
        return is_admin() || $user->id === $basicUser->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        dd('Failing at ' . self::class . '::creating');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BasicUser $basicUser): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BasicUser $basicUser): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BasicUser $basicUser): bool
    {
        return is_admin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BasicUser $basicUser): bool
    {
        return is_admin();
    }
}
