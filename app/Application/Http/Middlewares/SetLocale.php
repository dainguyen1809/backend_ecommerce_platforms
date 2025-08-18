<?php

namespace App\Application\Http\Middlewares;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            app()->setLocale($request->user()->locale);
        }

        return $next($request);
    }
}
