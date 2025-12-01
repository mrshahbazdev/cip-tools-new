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
            $panel->path('app'); // Central domain par ye /app par khulega
        } else {
            $panel->path(''); // Tenant par ye /admin par khulega (Safer for loops)

            // Domain parameter error fix karne ke liye hardcode domain
            if (!app()->runningInConsole()) {
                $panel->domain(request()->getHost());
            }
        }

        return $panel
            ->default()
            ->id('app')
            ->login(TenantLogin::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                // --- MOST IMPORTANT FIX FOR REDIRECT LOOP ---
                // Tenancy Middleware ko sabse upar rakhein
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
                \App\Http\Middleware\PreventSuperAdminAccess::class,
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
