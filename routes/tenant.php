<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\TenantAuthController;
use App\Livewire\TenantUserRegistration;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware(['web', InitializeTenancyByDomain::class])
    ->group(function () {

    // --- PUBLIC ROUTES (Unauthenticated) ---

    // 1. LANDING PAGE (Public)
    Route::get('/', function () {
        return view('tenant.landing');
    })->name('tenant.landing');

    // 2. LOGIN FORM (GET)
    Route::get('/login', [TenantAuthController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest'); // Only guests can access login page

    // 3. LOGIN PROCESS (POST)
    Route::post('/login', [TenantAuthController::class, 'login'])
        ->name('login.post');

    // 4. REGISTRATION FORM (GET)
    Route::get('/register', TenantUserRegistration::class)
        ->name('register')
        ->middleware('guest'); // Only guests can access registration

    // --- PROTECTED ROUTES (Require Authentication) ---
    Route::middleware('auth')->group(function () {

        // 5. DASHBOARD
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('dashboard');

        // 6. LOGOUT
        Route::post('/logout', [TenantAuthController::class, 'logout'])
            ->name('logout');

        // 7. Redirect root to dashboard when logged in
        Route::get('/', function () {
            return redirect()->route('dashboard');
        });
    });
});
