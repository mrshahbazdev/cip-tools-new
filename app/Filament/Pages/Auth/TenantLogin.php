<?php

namespace App\Filament\Pages\Auth;

use Closure;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TenantLogin extends BaseLogin
{
    // Override the form method to get inputs and call the parent
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberMeFormComponent(),
            ])
            ->statePath('data');
    }

    // Override the credential fetching method to inject the debugger
    protected function getCredentialsFromFormData(array $data): array
    {
        // --- DEBUG INJECTION START ---
        // Yahan hum dekhenge ki Auth attempt se pehle DB connection kya hai
        Log::warning('FINAL_AUTH_DEBUG: Active DB Connection: ' . DB::connection()->getDatabaseName());
        // --- DEBUG INJECTION END ---

        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }
}
