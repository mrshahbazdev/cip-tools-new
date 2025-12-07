<?php 

use Illuminate\Support\Facades\Route;
use App\Models\StaticPage;
use App\Livewire\SetupWizard; // Installer component

// --- 1. SETUP CHECK (CRITICAL GATEWAY) ---
// Check karte hain ki .env file mein APP_KEY set hua hai ya nahi.
if (empty(env('APP_KEY'))) {
    
    // Agar APP_KEY nahi hai, toh seedha installer page par bhej do
    Route::get('/setup', SetupWizard::class)->name('install.setup');

    // Baki sabhi requests ko installer page par redirect kar do
    Route::fallback(function () {
        return redirect()->route('install.setup');
    });
    
} else {

    // --- 2. CENTRAL DOMAIN SCOPING (Normal Application Flow) ---
    foreach (config('tenancy.central_domains') as $domain) {
        Route::domain($domain)->group(function () {

            Route::middleware(['web'])->group(function () {
                
                // Central Landing Page (Loads registration form)
                Route::get('/', function () {
                    return view('welcome');
                });
                
                // Dynamic Pages Handler (About, Privacy, etc.)
                // Note: The slug check is crucial for security
                Route::get('/{slug}', function ($slug) {
                    // StaticPage model se content fetch karein
                    $page = StaticPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
                    return view('central.static-page', ['page' => $page]);
                })->where('slug', '(about|privacy|terms|contact)'); 
                
                // Admin Login must be accessible
                // Ye route Filament ke liye zaroori hai
                Route::get('/admin/login', function () {
                    // Filament automatically handles the view render here
                    return view('filament.pages.auth.login');
                });
            });
        });
    }
}