<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain; // <-- Import
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains; // <-- Import
use Illuminate\Support\Facades\Blade;
use Filament\View\PanelsRenderHook;
class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Check karein ke current request Central Domain se hai ya nahi
        $isCentral = false;

        if (!app()->runningInConsole()) {
            $host = request()->getHost();
            $centralDomains = config('tenancy.central_domains') ?? [];
            $isCentral = in_array($host, $centralDomains);
        }

        // Logic:
        // Agar Central hai -> Path change karo ('app') taaki Landing Page '/' par chal sake.
        // Agar Tenant hai -> Path '/' rakho aur Domain fix karo taaki error na aaye.

        if ($isCentral) {
            $panel->path('app'); // Central domain par ye /app par khulega
        } else {
            $panel->path('');    // Tenant par ye direct / par khulega

            if (!app()->runningInConsole()) {
                $panel->domain(request()->getHost()); // Parameter error fix karne ke liye static domain
            }
        }

        return $panel
            ->default()
            ->id('app')
            ->login()
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => Blade::render('<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">')
            );
            // ->domain(...)  <-- IS LINE KO REMOVE KAR DEIN (Humne upar logic likh di hai)
            ->colors([
                'primary' => Color::Amber,
            ])
            // ... Baaki code same rahega ...
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->middleware([
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
            ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
