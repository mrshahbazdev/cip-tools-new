<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\PreventAccessFromTenantDomains;

// Ye middleware ensure karega ke ye routes sirf Central Domain par hi khulein
Route::middleware([
    'web',
    PreventAccessFromTenantDomains::class,
])->group(function () {

    Route::get('/', function () {
        return '<h1>Welcome to Central Domain (cip-tools.de)</h1>';
    });

});
