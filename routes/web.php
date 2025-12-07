<?php

use Illuminate\Support\Facades\Route;
use App\Models\StaticPage;
use App\Livewire\SetupWizard;

// --- 1. SETUP CHECK (CRITICAL GATEWAY) ---
// If APP_KEY is missing, register the setup route globally.
if (empty(env('APP_KEY'))) {
    Route::get('/setup', SetupWizard::class)->name('install.setup');

    // Fallback: Redirect everything else to setup if not configured
    Route::fallback(function () {
        return redirect()->route('install.setup');
    });
}

// --- 2. CENTRAL DOMAIN SCOPING (ALWAYS REGISTERED) ---
// Filament and the main Central Landing Page are registered here.

Route::middleware(['web'])->domain(config('tenancy.central_domains')[0])->group(function () {

    // Central Landing Page (Loads registration form)
    Route::get('/', function () {
        return view('welcome');
    })->name('central.landing'); // Naming the root landing page

    // Dynamic Pages Handler (About, Privacy, etc.)
    Route::get('/{slug}', function ($slug) {
        $page = StaticPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('central.static-page', ['page' => $page]);
    })->where('slug', '(about|privacy|terms|contact)');
});
