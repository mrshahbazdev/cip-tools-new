<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\CheckTrialExpiry; // Import

// Tenants must run under this middleware to identify the domain
Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES & LANDING ---
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [TenantAuthController::class, 'login'])->name('tenant.login');
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');
    
    // Expired Page (Must be accessible without CheckTrialExpiry)
    Route::get('/expired', function () {
        return view('tenant.expired-access'); 
    })->name('tenant.expired'); 

    // Root URL (Landing Page)
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('tenant.landing');
    })->name('tenant.landing');

    // --- LOGGED IN ROUTES (Auth Protection) ---
    Route::middleware('auth')->group(function () {
        
        // 1. SAFE ROUTES (Billing/Logout - No Expiry Check)
        Route::get('/billing', \App\Livewire\BillingPlans::class)->name('tenant.billing');
        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('logout'); 
        
        // 2. SENSITIVE ROUTES (Expiry Check Applied)
        Route::middleware([CheckTrialExpiry::class])->group(function () {
            
            // DASHBOARD ROUTE (The core protected asset)
            Route::get('/dashboard', function () {
                if (auth()->user()->isTenantAdmin()) {
                    return view('tenant.dashboard'); // Admin View
                }
                return view('tenant.user-dashboard'); // Normal User View
            })->name('tenant.dashboard');

            // USER MANAGEMENT (Protected)
            Route::get('/users', \App\Livewire\TenantUserManagement::class)->name('tenant.users.manage');
        });
    });
});