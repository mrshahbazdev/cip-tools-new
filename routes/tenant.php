<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES ---
    // 1. LOGIN FORM (GET)
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login'); 
    
    // 2. LOGIN PROCESS (POST)
    Route::post('/login', [TenantAuthController::class, 'login'])->name('tenant.login'); 

    // 3. REGISTRATION ROUTE
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');

    // 4. ROOT URL (Landing Page)
    Route::get('/', function () {
        // Fix: Agar user logged in hai toh seedha /dashboard par bhej do
        if (auth()->check()) {
            return redirect()->route('tenant.dashboard'); 
        }
        return view('tenant.landing'); 
    })->name('tenant.landing');


    // --- LOGGED IN ROUTES (Private) ---
    Route::middleware('auth')->group(function () {
        
        // 5. DASHBOARD ROUTE (The final target)
        // Ye route /dashboard ko 'tenant.dashboard' naam dega.
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('tenant.dashboard'); // <--- CRITICAL: Yahan naam define hua

        // 6. LOGOUT ROUTE
        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('logout'); 
    });
});