<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

// Tenants must run under this middleware to identify the domain
Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES ---
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [TenantAuthController::class, 'login'])->name('tenant.login');
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');

    // 1. LOGGED OUT ROOT (Landing Page)
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('tenant.dashboard'); // Agar logged in ho, toh dashboard par bhej do
        }
        return view('tenant.landing');
    })->name('tenant.landing');

    // --- PRIVATE DASHBOARD ROUTES ---

    // 2. DASHBOARD ROUTE (Protected by Auth Check)
    Route::get('/dashboard', function () {
        // CRITICAL FIX: Agar user Tenant Admin nahi hai, toh use simple page par bhej do
        if (! auth()->user()->isTenantAdmin()) {
            // Assume /landing route is safe for all logged-in users
            return redirect()->route('tenant.landing'); 
        }
        
        return view('tenant.dashboard'); // Tenant Admin ko full dashboard dikhao
    })->name('tenant.dashboard');
    
    // 3. LOGOUT ROUTE (No Auth Middleware, just POST)
    Route::post('/logout', [TenantAuthController::class, 'logout'])->name('logout'); 
});