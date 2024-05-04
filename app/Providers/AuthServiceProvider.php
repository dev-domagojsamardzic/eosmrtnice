<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Member;
use App\Models\Partner;
use App\Policies\AdPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\MemberPolicy;
use App\Policies\PartnerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
