<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\CheckTrialExpiry; // <-- Naya Import

// Tenants must run under this middleware to identify the domain
Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES & LANDING ---
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [TenantAuthController::class, 'login'])->name('tenant.login');
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');

    // Naya Fix: Expired Page Route (Must be outside 'auth' middleware)
    Route::get('/expired', function () {
        return view('tenant.expired-access'); 
    })->name('tenant.expired'); // <-- Ye route access lock ka target hai

    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('tenant.landing');
    })->name('tenant.landing');

    // --- LOGGED IN ROUTES (Private) ---
    // CRITICAL FIX: Auth middleware ke saath CheckTrialExpiry ko shamil karein
    Route::middleware(['auth', CheckTrialExpiry::class]) 
        ->group(function () {
        
        // 1. DASHBOARD ROUTE (Protected)
        Route::get('/dashboard', function () {
            // Role check karke sahi view render karein
            if (auth()->user()->isTenantAdmin()) {
                return view('tenant.dashboard'); // Admin View
            }
            return view('tenant.user-dashboard'); // Normal User View
        })->name('tenant.dashboard');

        // 2. MANAGEMENT ROUTES
        Route::get('/users', \App\Livewire\TenantUserManagement::class)->name('tenant.users.manage');
        Route::get('/billing', \App\Livewire\BillingPlans::class)->name('tenant.billing');
        
        // 3. LOGOUT ROUTE
        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('logout'); 
    });
});