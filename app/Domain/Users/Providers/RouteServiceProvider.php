<?php

namespace App\Domain\Users\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
    }

    public function map(Router $router): void
    {
        if (config('register.api_routes')) {
            $this->mapApiRoutes($router);
        }
    }

    protected function mapApiRoutes(Router $router): void
    {
        $router->group([
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
            'middleware' => ['api'],
        ], function (Router $router) {
            // list routes
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        RateLimiter::for('hard', function (Request $request) {
            return Limit::perMinute(2)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
