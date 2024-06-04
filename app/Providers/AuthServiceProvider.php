<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Deceased;
use App\Models\Member;
use App\Models\Offer;
use App\Models\Partner;
use App\Models\User;
use App\Policies\AdPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\DeceasedPolicy;
use App\Policies\MemberPolicy;
use App\Policies\OfferPolicy;
use App\Policies\PartnerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Partner::class => PartnerPolicy::class,
        Member::class => MemberPolicy::class,
        Company::class => CompanyPolicy::class,
        Ad::class => AdPolicy::class,
        Offer::class => OfferPolicy::class,
        Deceased::class => DeceasedPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Check if ad has valid offers
        Gate::define('create-ad-offer', static function (User $user, Ad $ad) {
            return is_admin() && $ad->offers()->valid()->count() === 0;
        });

        Gate::define('set-ad-type', static function (User $user, Ad $ad) {
            return is_admin() || (is_partner() && !$ad->exists);
        });
    }
}
