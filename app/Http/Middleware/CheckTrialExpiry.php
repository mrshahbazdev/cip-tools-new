<?php
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant; // Make sure this is imported

class CheckTrialExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Agar request central domain se nahi hai aur tenant identified hai
        if (tenancy()->tenant) {
            
            // CRITICAL FIX: Tenant object ko database se fresh load karein
            $tenant = Tenant::find(tenancy()->tenant->id);
            
            // Critical Check: Check Expiry Conditions
            $isTrialExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
            $isNotActive = $tenant->plan_status !== 'active';

            // Agar trial khatam ho gaya hai aur plan active nahi hai, ya is_active flag off hai
            if ($isExpired && $isNotActive) {
                
                // 2. Agar user expired page par nahi hai, toh redirect karo
                if (! $request->routeIs('tenant.expired')) { 
                    auth()->logout(); // Logout the user for security
                    return redirect()->route('tenant.expired');
                }
            }
        }
        
        return $next($request);
    }
}