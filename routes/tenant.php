<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES ---

    // 1. LOGIN FORM ROUTE (GET)
    // Use just 'login' since auth middleware looks for this name
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])
        ->name('login'); // Global fallback name (for redirecting unauthed users)

    // 2. LOGIN PROCESS ROUTE (POST) - This is the form action
    Route::post('/login', [TenantAuthController::class, 'login'])
        ->name('tenant.login'); // <-- CRITICAL FIX: The form action name goes here!

    // 3. LOGOUT ROUTE
    Route::post('/logout', [TenantAuthController::class, 'logout'])
        ->name('tenant.logout')
        ->name('logout');

    // 4. ROOT URL (Landing Page vs Dashboard Check)
    Route::get('/', function () {
        // CRITICAL FIX: Public Landing Page dikhao
        return view('tenant.landing');
    })->name('tenant.landing');

    // --- LOGGED IN ROUTES (Private) ---
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect()->route('tenant.dashboard');
        });

        // 4. REGISTRATION FORM ROUTE
        Route::get('/register', TenantUserRegistration::class)
            ->name('tenant.register');  // <-- CRITICAL FIX: The form action name goes here!
        // 5. DASHBOARD ROUTE
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('tenant.dashboard');

        // 6. LOGOUT ROUTE
        // Use just 'logout' since Laravel's default expects this
        Route::post('/logout', [TenantAuthController::class, 'logout'])
            ->name('logout');
    });
});
