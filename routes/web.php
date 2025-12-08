<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\SetupWizard;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

// --- 1. SETUP CHECK (CRITICAL GATEWAY) ---
if (empty(env('APP_KEY'))) {
    Route::get('/setup', SetupWizard::class)->name('install.setup');
    Route::fallback(function () {
        return redirect()->route('install.setup');
    });
}

// --- 2. CENTRAL DOMAIN ROUTES ---
// These routes ONLY run on domains listed in tenancy.central_domains.
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->middleware('web')->group(function () {

        // Central Landing Page (Handles cip-tools.de/)
        Route::get('/', function () {
            return view('welcome');
        })->name('central.landing');

        // Login Redirect (Handles cip-tools.de/login)
        Route::get('/login', function () {
            return redirect()->route('central.landing')->with('info', 'Please use your project subdomain to log in.');
        })->name('central.login');

        // Static Pages Handler (Dynamic handler logic here)
        // ... (Your static page routes)
    });
}

// --- 3. TENANT DOMAIN ROUTES (Must be defined in routes/tenant.php) ---
// This block ensures that any non-central domain attempt gets routed
// through the tenant process if it exists.
// IMPORTANT: We do NOT define any routes here. This structure is mainly for clarity.
// All your tenant routes should reside exclusively in routes/tenant.php.
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function() {
    // This empty group ensures the middleware is registered globally,
    // but the routes are loaded from routes/tenant.php only.
    // Ensure you haven't accidentally placed any central routes here.
});
