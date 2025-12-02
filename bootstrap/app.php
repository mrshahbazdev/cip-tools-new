<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException; // <-- Import 2]
use Illuminate\Console\Scheduling\Schedule;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // SiteGround Proxy Fix
        $middleware->trustProxies(at: '*');

        // Ye headers zaroori hain SiteGround ke liye
        $middleware->trustProxies(headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB
        );

    })
    ->withSchedule(function (Schedule $schedule) { 
        // Daily check for trial expiry
        $schedule->command('tenant:check-expiry')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (TenantCouldNotBeIdentifiedOnDomainException $e, Request $request) {

            // 1. Check if the current host is NOT in the list of central domains
            if (! in_array($request->getHost(), config('tenancy.central_domains'))) {
                // 2. Agar tenant ID nahi mila, toh 404 Not Found return karo
                return response()->view('errors.404', [], 404);
            }
        });
    })->create();
