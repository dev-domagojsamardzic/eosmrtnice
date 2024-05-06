<?php

namespace App\Providers;

use App\Models\Ad;
use App\Observers\AdObserver;
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
    }
}
