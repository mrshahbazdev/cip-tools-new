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
        // Agar hum production (live) environment mein hain, to HTTPS force karein
        if($this->app->environment('production') || true) { // '|| true' filhal testing ke liye lagaya hai
            URL::forceScheme('https');
        }
    }
}
