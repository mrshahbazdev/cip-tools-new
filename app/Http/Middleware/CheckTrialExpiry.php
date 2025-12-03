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
    
            $tenant = Tenant::find(tenancy()->tenant->id);
            
            $isTrialExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            $isNotActive = $tenant->plan_status !== 'active';

            // 1. Agar trial date guzar chuki hai AUR plan active nahi hai, toh action lo
            if ($isTrialExpired && $isNotActive) {
                
                // CRITICAL FIX: Database status ko 'expired' set karein
                if ($tenant->plan_status !== 'expired') {
                    $tenant->plan_status = 'expired';
                    $tenant->is_active = false; 
                    $tenant->save(); // DB update ho gaya
                }
                
                $user = auth()->user();
                
                // 2. Determine Target Route (Final Redirect)
                // Admin ko billing par bhejo, baki sabko generic expired page par.
                $targetRoute = ($user && $user->isTenantAdmin()) ? 'tenant.billing' : 'tenant.expired';
                
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