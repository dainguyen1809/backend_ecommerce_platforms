<?php

return [
    App\Application\Providers\AppServiceProvider::class,
    App\Application\Providers\SwaggerUiServiceProvider::class,

    // Domain
    App\Domain\Users\Providers\DomainServiceProvider::class,

    // thrid-party providers

    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
