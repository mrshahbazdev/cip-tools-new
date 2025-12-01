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
    // Ye line 'login' named route define karti hai, jo Laravel core systems (jaise Authenticate Middleware) ko chahiye.
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])
        ->name('tenant.login')
        ->name('login'); // <-- CRITICAL FIX: Default global login name

    // 2. LOGIN PROCESS ROUTE (POST)
    Route::post('/login', [TenantAuthController::class, 'login']);

    // 3. REGISTRATION ROUTE
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');


    // 4. ROOT URL (Landing Page vs Dashboard Check)
    Route::get('/', function () {
        if (auth()->check()) {
            // Agar user logged in hai, toh unhein seedha dashboard par bhej de
            return redirect()->route('tenant.dashboard');
        }
        // Agar logged out ho, toh public landing page dikhao
        return view('tenant.landing');
    })->name('tenant.landing');


    // --- LOGGED IN ROUTES (Private) ---
    Route::middleware('auth')->group(function () {

        // 5. DASHBOARD ROUTE
        Route::get('/dashboard', function () {
            // Is page par sirf woh users aa sakte hain jo logged in hain
            return view('tenant.dashboard');
        })->name('tenant.dashboard');

        // 6. LOGOUT ROUTE
        // 'logout' naam bhi define karna zaroori hai
        Route::post('/logout', [TenantAuthController::class, 'logout'])
            ->name('tenant.logout')
            ->name('logout'); // <-- CRITICAL FIX: Default global logout name
    });
});
