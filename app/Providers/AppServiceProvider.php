<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Import karein
use Stancl\Tenancy\Events\TenancyInitialized; // Import karein
use Illuminate\Support\Facades\Event;
use App\Models\User; // Import karein
use App\Models\TenantUser;
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
            Event::listen(TenancyInitialized::class, function (TenancyInitialized $event) {
                // web guard ke 'provider' (users) ko 'tenant_users' model par set karein
                config(['auth.providers.users.model' => TenantUser::class]);

                // Ensure the web guard still uses the 'users' provider
                config(['auth.guards.web.provider' => 'users']);
            });
    }
}
