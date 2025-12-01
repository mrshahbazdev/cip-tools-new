<?php

namespace App\Filament\Pages\Auth;

use Closure;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Log; // Added for debugging
use Illuminate\Support\Facades\DB;  // Added for debugging

class TenantLogin extends BaseLogin
{
    // Override the form method to add the debug check
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Filament components are now accessed directly via the trait/class
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                //$this->getRememberMeFormComponent(), // Ye method ab sahi se inherit hoga
            ])
            ->statePath('data');
    }
    protected function getRedirectUrl(): string
    {
        // CRITICAL FIX: Explicitly redirect to the Tenant User Home Page
        return \App\Filament\Pages\TenantUserHomePage::getUrl();
    }
    // Override the credential fetching method to inject the debugger (Existing logic)
    protected function getCredentialsFromFormData(array $data): array
    {
        // --- DEBUG INJECTION START ---
        // Final check: Agar ye Central DB aaya, to Login fail hoga
        Log::warning('FINAL_AUTH_DEBUG: Active DB Connection: ' . DB::connection()->getDatabaseName());
        // --- DEBUG INJECTION END ---

        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }
}
