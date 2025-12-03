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
            
            // CRITICAL: Tenant object ko database se fresh load karein
            $tenant = Tenant::find(tenancy()->tenant->id);
            
            $hasDatePassed = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            
            // --- 1. AUTO-EXPIRE LOGIC ---
            // Agar date guzar chuki hai AUR plan abhi bhi 'active' ya 'trial' hai, 
            // toh status ko forcefully 'expired' par update kar do.
            if ($hasDatePassed && ($tenant->plan_status === 'active' || $tenant->plan_status === 'trial')) {
                $tenant->plan_status = 'expired';
                $tenant->is_active = false;
                $tenant->save(); // Database update ho gaya
            }

            // --- 2. ENFORCED LOCK CHECK ---
            $isExpiredAndLocked = $tenant->plan_status === 'expired';

            if ($isExpiredAndLocked) {
                
                $user = auth()->user();
                
                // Determine Target Route based on role
                if ($user && $user->isTenantAdmin()) {
                    // Admin ko seedha Billing page par bhej do
                    $targetRoute = 'tenant.billing'; 
                } else {
                    // Normal user ko generic expiry page par bhej do
                    $targetRoute = 'tenant.expired'; 
                }

                // Check agar user already target page par nahi hai
                if (! $request->routeIs($targetRoute)) {
                    
                    // User ko logout kar dein taaki session lock ho jaye
                    if (auth()->check()) {
                        auth()->logout(); 
                    }
                    return redirect()->route($targetRoute);
                }
            }
        }
        
        return $next($request);
    }
}