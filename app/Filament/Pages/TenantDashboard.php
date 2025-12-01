<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TenantDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tenant-dashboard';
    public static function canAccess(): bool
    {
        // Agar user logged in hai aur Tenant Admin hai, tabhi access milega
        return auth()->check() && auth()->user()->isTenantAdmin();
    }

    // Agar user Admin nahi hai, to redirect kar do
    protected function authorizeAccess(): void
    {
        if (! auth()->check() || ! auth()->user()->isTenantAdmin()) {
            // Unhe seedha landing page par bhej do (Step 3.2 mein define hoga)
            redirect()->to(url('/'))->send();
        }
    }
}
