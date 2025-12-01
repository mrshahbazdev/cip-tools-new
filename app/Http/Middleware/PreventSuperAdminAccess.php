<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSuperAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Agar user logged in hai
        if (auth()->check()) {

            // 2. Check karein ki user Super Admin hai ya nahi
            if (auth()->user()->isSuperAdmin()) {

                // 3. Central Admin Panel par redirect kar do
                // Central domain par 'admin' path ko target karte hain
                return redirect()->to(config('app.url') . '/admin');
            }
        }

        // Agar user tenant hai ya logged out hai, to aage jane do
        return $next($request);
    }
}
