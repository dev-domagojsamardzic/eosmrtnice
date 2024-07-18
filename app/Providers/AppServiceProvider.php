<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Condolence;
use App\Observers\AdObserver;
use App\Observers\CondolenceObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Ad::observe(AdObserver::class);
        Condolence::observe(CondolenceObserver::class);
    }
}
