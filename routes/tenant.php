<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController; // Naya controller use karenge
use App\Livewire\TenantUserRegistration; // Existing Livewire component

// Tenant Routes must run under this middleware to identify the domain
Route::middleware(['web', \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC AUTH ROUTES ---
    // User registration (Livewire component use karein)
    Route::get('/register', TenantUserRegistration::class)->name('tenant.register');

    // Custom Login Controller
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('tenant.login');
    Route::post('/login', [TenantAuthController::class, 'login']);

    // Tenant Root/Landing Page (Jahan sabse pehle user dekhega)
    Route::get('/', function () {
        if (auth()->check()) {
            return view('tenant.dashboard'); // Agar logged in ho
        }
        return view('tenant.landing'); // Agar logged out ho
    })->name('tenant.landing');

    // --- LOGGED IN ROUTES (Private) ---
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
             return view('tenant.dashboard'); // Simple Dashboard view
        })->name('tenant.dashboard');

        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('tenant.logout');
    });
});
