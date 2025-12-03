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
            
            // 2. Define Expiry Conditions
            $isTrialExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            $isNotActive = $tenant->plan_status !== 'active';

            // --- CRITICAL FIX: Variable name correction applied (Use $isTrialExpired) ---
            if ($isTrialExpired && $isNotActive) {
                
                // 3. Agar user expired page par nahi hai, toh redirect karo
                if (! $request->routeIs('tenant.expired')) { 
                    auth()->logout(); 
                    // redirect()->route() use karein kyunki humne isko stable kiya tha
                    return redirect()->route('tenant.expired'); 
                }
            }
        }
        
        return $next($request);
    }
}