<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\AdsOffer;
use App\Models\PostsOffer;
use App\Observers\AdObserver;
use App\Observers\OfferObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Ad::observe(AdObserver::class);
        AdsOffer::observe(OfferObserver::class);
        PostsOffer::observe(OfferObserver::class);
    }
}
