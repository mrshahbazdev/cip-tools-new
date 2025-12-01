<?php

namespace App\Filament\Pages;
use App\Models\User;
use Filament\Pages\Page;

class TenantUserHomePage extends Page
{
    // ... baaki properties ...
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.tenant-user-home-page';

    // CRITICAL FIX: Ye page har authenticated user ko accessible hai
    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public function getTitle(): string
    {
        return 'Welcome, ' . auth()->user()->name . '!';
    }
}
