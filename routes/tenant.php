<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

// Tenants must run under this middleware to identify the domain
Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES ---

    // 1. LOGIN FORM ROUTE (GET)
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])
        ->name('tenant.login')
        ->name('login'); // <-- CRITICAL: Global Fallback Name

    // 2. LOGIN PROCESS ROUTE (POST)
    Route::post('/login', [TenantAuthController::class, 'login']);

    // 3. REGISTRATION ROUTE
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');


    // 4. ROOT URL (Landing Page vs Dashboard Check)
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('tenant.landing');
    })->name('tenant.landing');


    // --- LOGGED IN ROUTES (Private) ---
    Route::middleware('auth')->group(function () {

        // 5. DASHBOARD ROUTE
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('tenant.dashboard');

        // 6. LOGOUT ROUTE
        Route::post('/logout', [TenantAuthController::class, 'logout'])
            ->name('tenant.logout')
            ->name('logout'); // <-- CRITICAL: Global Fallback Logout Name
    });
});
