<?php

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Ye DB Switch karega
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Root URL ko Filament handle kar raha hai, isliye hum isay chhor dete hain

    // --- DEBUG ROUTES ---
    Route::get('/debug-db', function () {
        return [
            'Current Database' => \DB::connection()->getDatabaseName(),
            'Tenant ID' => tenant('id'),
            'User Count' => User::count(),
            'First User' => User::first(),
        ];
    });

    Route::get('/force-login', function () {
        $user = User::first();
        if (!$user) return 'Abhi bhi User nahi mila (Database khali hai)';

        auth()->login($user);

        // Root path is /admin if path is 'admin'
        return redirect('/admin');
    });

});
