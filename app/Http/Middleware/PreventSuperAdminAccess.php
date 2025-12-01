<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSuperAdminAccess
{
    /**
     * Ye middleware Super Admin ko Tenant Dashboard (subdomain) access karne se rokta hai.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if a user is logged in
        if (auth()->check()) {

            // 2. Check agar woh user Super Admin hai (users table me is_admin = true)
            // isSuperAdmin() method App\Models\User.php se aati hai.
            if (auth()->user()->isSuperAdmin()) {

                // 3. Agar Super Admin hai, to unhe seedha Central Admin Panel par bhej do.
                // Ye unhe tenant context se bahar nikalta hai.
                return redirect()->to(config('app.url') . '/admin');
            }
        }

        // Agar user tenant admin/user hai ya logged out hai, to aage jane do
        return $next($request);
    }
}
