<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant; 

class CheckTrialExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        if (tenancy()->tenant) {
    
            $tenant = Tenant::find(tenancy()->tenant->id);
            
            $isExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            $isNotActive = $tenant->plan_status !== 'active';

            // 1. Agar trial khatam ho gaya hai aur plan active nahi hai
            if ($isExpired && $isNotActive) {
                
                $user = auth()->user();
                $isAdmin = $user && $user->isTenantAdmin();
                
                // --- CRITICAL FIX START ---

                // A) Safe Routes ko chhod dein (Logout, Expired page, Billing page)
                if ($request->routeIs('logout') || $request->routeIs('tenant.expired')) {
                    return $next($request);
                }

                // B) Admin Check: Agar Admin hai
                if ($isAdmin) {
                    // Admin ko Billing page par bhej do (Agar woh wahan nahi hai)
                    if (!$request->routeIs('tenant.billing')) {
                        return redirect()->route('tenant.billing');
                    }
                    // Agar Admin already billing page par hai, toh access de do
                    return $next($request); 
                } 
                
                // C) Normal User/Default Lock
                // Agar normal user hai aur expired hai, toh expired page par bhej do
                if (!$request->routeIs('tenant.expired')) {
                    return redirect()->route('tenant.expired');
                }
            }
        }

        return $next($request);
    }
}