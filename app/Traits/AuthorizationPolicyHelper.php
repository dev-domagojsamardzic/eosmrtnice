<?php

namespace App\Traits;

use App\Models\Ad;
use App\Models\User;

trait AuthorizationPolicyHelper
{
    /**************************
     ***    AdPolicy.php    ***
     **************************\
    /**
     * Does user own company related to Ad?
     *
     * @param User $user
     * @param Ad $ad
     * @return bool
     */
    protected function userOwnsAdRelatedCompany(User $user, Ad $ad): bool
    {
        return $user->companies()
            ->where('id', $ad->company_id)
            ->exists();
    }

    /**
     * Does user own at least one active company?
     * @param User $user
     * @return bool
     */
    protected function userOwnsAtLeastOneCompany(User $user): bool
    {
        return $user->companies()
            ->where('active', 1)
            ->exists();
    }

    protected function userOwnsCompaniesAvailableForAds(User $user): bool
    {
        return $user->companies()
            ->where('active', 1)
            ->whereDoesntHave('ads', function ($query) {
                $query->whereNull('expired_at');
            })
            ->exists();
    }
}
