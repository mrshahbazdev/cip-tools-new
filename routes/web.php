<?php

use Illuminate\Support\Facades\Route;

// Config se central domains utha kar sirf unhi par ye routes chalayenge
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::middleware(['web'])->group(function () {
            Route::get('/', function () {
                return '<h1>Welcome to Central Domain (cip-tools.de)</h1>';
            });

            // Future mein Registration routes yahan ayenge
        });

    });
}
