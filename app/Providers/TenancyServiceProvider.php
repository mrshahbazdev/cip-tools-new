<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    // Single DB setup mein iski zarurat nahi, lekin code mein rehne dein.
    public static string $controllerNamespace = '';

    public function events()
    {
        return [
            // Tenant Created event. Jobs hata diye gaye hain kyunki hum Single DB mein hain.
            Events\TenantCreated::class => [
                JobPipeline::make([
                    // Jobs\CreateDatabase::class, // REMOVED (No permission)
                    // Jobs\MigrateDatabase::class, // REMOVED (Table per tenant)
                ])->send(function (Events\TenantCreated $event) {
                    return $event->tenant;
                })->shouldBeQueued(false),
            ],

            // Tenant Deleted event. Jobs hata diye gaye hain taaki DROP DATABASE error na aaye.
            Events\TenantDeleted::class => [
                JobPipeline::make([
                    // Jobs\DeleteDatabase::class, // REMOVED (No permission)
                ])->send(function (Events\TenantDeleted $event) {
                    return $event->tenant;
                })->shouldBeQueued(false),
            ],

            // Core Tenancy events (Ye zaruri hain context switching ke liye)
            Events\TenancyInitialized::class => [
                Listeners\BootstrapTenancy::class,
            ],
            Events\TenancyEnded::class => [
                Listeners\RevertToCentralContext::class,
            ],

            // ... baaki default events ...
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->bootEvents();
        $this->mapRoutes();

        // Middleware priority is being handled in AppPanelProvider for this setup.
        // $this->makeTenancyMiddlewareHighestPriority();
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Event::listen($event, $listener);
            }
        }
    }

    // Ye method routes/tenant.php ko load karta hai (Filament is par depend karta hai)
    protected function mapRoutes()
    {
        $this->app->booted(function () {
            if (file_exists(base_path('routes/tenant.php'))) {
                Route::namespace(static::$controllerNamespace)
                    ->group(base_path('routes/tenant.php'));
            }
        });
    }

    // Optional: Is method ko comment kar dein agar aapne use nahi kiya
    protected function makeTenancyMiddlewareHighestPriority()
    {
        // ...
    }
}
