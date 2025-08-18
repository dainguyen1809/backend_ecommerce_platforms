<?php

return [
    App\Application\Providers\AppServiceProvider::class,
    App\Application\Providers\SwaggerUiServiceProvider::class,

    // thrid-party providers

    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
