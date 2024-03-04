<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN = '/admin/dashboard';
    public const PARTNER = '/partner/dashboard';
    public const USER = '/user/dashboard';
    public const HOME = '/user/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', static function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // custom route groups
            Route::middleware(['web', 'auth', 'verified', 'admin'])
                ->prefix('admin')
                ->as('admin.')
                ->scopeBindings()
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', 'verified', 'partner'])
                ->prefix('partner')
                ->as('partner.')
                ->scopeBindings()
                ->group(base_path('routes/partner.php'));

            Route::middleware(['web', 'auth', 'verified', 'user'])
                ->prefix('user')
                ->as('user.')
                ->scopeBindings()
                ->group(base_path('routes/user.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
