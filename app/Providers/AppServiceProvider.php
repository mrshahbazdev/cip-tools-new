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
        // Agar environment production hai ya local nahi hai
        if ($this->app->environment('production') || config('app.env') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // Ye line add karein taaki CSS/JS bhi HTTPS ho jayein
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
