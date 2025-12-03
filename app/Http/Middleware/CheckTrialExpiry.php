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
        // 1. Agar request central domain se nahi hai aur tenant identified hai
        if (tenancy()->tenant) {
            
            // CRITICAL FIX: Tenant object ko database se fresh load karein
            // Note: Ye check already logged-in user context mein chalta hai
            $tenant = Tenant::find(tenancy()->tenant->id);
            
            $isTrialExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            $isNotActive = $tenant->plan_status !== 'active';

            // Agar trial khatam ho gaya hai aur plan active nahi hai
            if ($isTrialExpired && $isNotActive) {
                
                $user = auth()->user(); // Logged-in user
                
                // 1. Determine Target Route based on role
                if ($user && $user->isTenantAdmin()) {
                    // Admin ko seedha Billing page par bhej do
                    $targetRoute = 'tenant.billing'; 
                } else {
                    // Normal user ya logged-out user ko generic expiry page par bhej do
                    $targetRoute = 'tenant.expired'; 
                }

                // 2. Check agar user already target page par nahi hai
                if (! $request->routeIs($targetRoute)) {
                    // CRITICAL FIX: Logout nahi karna hai
                    return redirect()->route($targetRoute);
                }
            }
        
        return $next($request);
        }
    }
}