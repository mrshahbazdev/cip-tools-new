<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TenantDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tenant-dashboard';
    public static function canAccess(): bool
    {
        // CRITICAL FIX: Pehle check karein ki koi user logged in hai ya nahi
        if (! auth()->check()) {
            return false;
        }

        // Ab user object available hai, toh isTenantAdmin call karo
        return auth()->user()->isTenantAdmin();
    }

    // Agar user Admin nahi hai, to redirect kar do
    protected function authorizeAccess(): void
    {
        static::authorizeAccess();
        // if (! auth()->check() || ! auth()->user()->isTenantAdmin()) {
        //     // Unhe seedha landing page par bhej do (Step 3.2 mein define hoga)
        //     redirect()->to(url('/'))->send();
        // }
    }
}
