<?php // <-- YE TAG ZAROOR HONA CHAHIYE, WOH BHI SABSE UPAR

use Illuminate\Support\Facades\Route;

// Sabse pehle, ensure karein ke wo DEBUGGING BLOCK poora HATA diya gaya hai.

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::middleware(['web'])->group(function () {

            // Central Landing Page
            Route::get('/', function () {
                return view('welcome');
            });

        });
    });
}

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
