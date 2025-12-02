<?php
// app/Http/Middleware/RedirectIfAuthenticated.php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    // CRITICAL FIX: Global Redirect path ko /dashboard par set karein
    protected string $redirectTo = '/dashboard'; 
    // Agar aapka route /home par hai, to yahan /home likhein. /dashboard is the right path here.

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Yahan woh user ko seedha dashboard par bhej dega
                return redirect($this->redirectTo); 
            }
        }

        return $next($request);
    }
}