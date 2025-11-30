<?php

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::middleware(['web'])->group(function () {

            // Yahan hum View return kar rahe hain
            Route::get('/', function () {
                return view('welcome');
            });

            // Future routes...
        });

    });
}
