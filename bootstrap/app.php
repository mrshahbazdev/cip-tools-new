<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // --- YE LINE ADD KAREIN ---
        // SiteGround ke proxies par trust karein
        $middleware->trustProxies(at: '*');

        // Agar zaroorat ho to ye bhi add kar sakte hain (filhal sirf upar wala kaafi hai)
        // $middleware->trustHelpers();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
