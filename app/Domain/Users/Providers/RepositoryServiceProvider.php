<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Repositories\EloquentUserRepository;
use App\Infrastructure\Abstracts\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, function () {
            return new EloquentUserRepository(new User());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [UserRepository::class];
    }
}
