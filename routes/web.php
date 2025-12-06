<?php // <-- YE TAG ZAROOR HONA CHAHIYE, WOH BHI SABSE UPAR

use Illuminate\Support\Facades\Route;


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
Route::get('/{slug}', function ($slug) {
    $page = App\Models\StaticPage::where('slug', $slug)->where('is_published', true)->firstOrFail();

    // Yahan ek custom view render hoga (e.g., 'central.static-page')
    return view('central.static-page', ['page' => $page]);
})->where('slug', '(about|privacy|terms|contact)'); // Only allow specific slugs
