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
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Blade;
use Filament\View\PanelsRenderHook;
use App\Filament\Pages\Auth\TenantLogin;
use App\Http\Middleware\PreventSuperAdminAccess;
use App\Filament\Pages\TenantUserHomePage; // Naya Safe Landing Page

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // 1. Check karein ke current request Central Domain se hai ya Tenant se
        $isCentral = false;
        if (!app()->runningInConsole()) {
            $host = request()->getHost();
            $centralDomains = config('tenancy.central_domains') ?? [];
            $isCentral = in_array($host, $centralDomains);
        }

        // 2. Path Logic Set Karein
        if ($isCentral) {
            $path = 'app'; // Central domain par ye /app par khulega
        } else {
            $path = ''; // Tenant domain par ye / (root) par khulega (Final stable path)
        }

        return $panel
            ->default()
            ->id('app')
            ->path($path) // Path yahan set hoga
            ->login(TenantLogin::class)
            // CRITICAL FIX: homeUrl ko Lazy Load karna (fn () => ...)
            ->homeUrl(fn () => TenantUserHomePage::getUrl())
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\TenantUserHomePage::class, // Safe Landing Page (Sabse Pehle)
                \App\Filament\Pages\TenantDashboard::class, // Restricted Admin Page
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                // --- MOST IMPORTANT FIX FOR REDIRECT LOOP ---
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
                \App\Http\Middleware\PreventSuperAdminAccess::class, // Super Admin Block

                // Phir Standard Middleware aayenge
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
            ->authMiddleware([
                Authenticate::class,
            ])
            // --- SSL / MIXED CONTENT FIX ---
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => Blade::render('<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">')
            );
    }
}
