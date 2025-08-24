<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Http\Controllers\RegisterController;
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
        $router->group(
            [
                'namespace'  => $this->namespace,
                'prefix'     => 'api/v1/auth',
                'middleware' => ['api'],
            ],
            function (Router $router) {
                $this->mapRoutesWhenGuest($router);
            },
        );
    }

    private function mapRoutesWhenGuest(Router $router): void
    {
        $router->group(['middleware' => 'guest'], function () use ($router) {
            $router->post('register', [RegisterController::class, 'register'])->name('api.auth.register');
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
