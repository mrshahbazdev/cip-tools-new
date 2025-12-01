<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

// Ab hum routes yahan nahi likhenge, Filament khud handle karega.
// Lekin agar future me custom routes chahiye hon, to yahan likh sakte hain.

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
])->group(function () {
    // Route::get('/', function () {
    //    return 'This will now be handled by Filament';
    // });
    Route::get('/', function () {
        return view('tenant.landing');
    })->name('tenant.landing');
});
