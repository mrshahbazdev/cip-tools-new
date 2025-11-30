<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Ye sabse important line hai
])->group(function () {

    Route::get('/', function () {
        return '<h1>Success! You are on Tenant: ' . tenant('id') . '</h1>';
    });

});
