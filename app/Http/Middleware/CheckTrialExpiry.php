<?php
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTrialExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Agar request central domain se nahi hai, aur tenant identified hai
        if (tenancy()->tenant && ! in_array(request()->getHost(), config('tenancy.central_domains'))) {
            $tenant = tenancy()->tenant;
            
            // Critical Check: Check if trial date has passed AND plan is still on trial status
            $isExpired = $tenant->trial_ends_at && $tenant->trial_ends_at->lessThan(now());
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