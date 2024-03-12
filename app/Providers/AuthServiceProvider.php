<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\BasicUser;
use App\Models\Partner;
use App\Policies\BasicUserPolicy;
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
        BasicUser::class => BasicUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
