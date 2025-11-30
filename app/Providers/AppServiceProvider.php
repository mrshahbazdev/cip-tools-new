<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Import karein

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
        // Agar hum Localhost par nahi hain (yani Server par hain)
        if ($this->app->environment('production') || request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {

            // 1. URL Scheme Force Karein
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // 2. Request ko batayein ke ye HTTPS hai
            request()->server->set('HTTPS', 'on');
        }
    }
}
