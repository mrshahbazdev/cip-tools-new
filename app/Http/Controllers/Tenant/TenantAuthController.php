<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Stancl\Tenancy\Resolvers\DomainTenantResolver; // Context check ke liye

class TenantAuthController extends Controller
{
    // 1. LOGIN FORM DIKHANA
    public function showLoginForm()
    {
        // Agar user already logged in hai, toh unhe seedha dashboard par bhej do
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        
        // Login view ko load karein
        return view('tenant.login');
    }

    // 2. LOGIN PROCESS (FORM SUBMIT)
    public function login(Request $request)
    {
        // Validation check
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // --- CRITICAL SECURITY FIX START (User Isolation) ---
        
        // 1. Current Tenant ID ko fetch karein (Jo InitializeTenancyByDomain middleware se set hua hai)
        $tenantId = tenant('id');

        // Agar tenant ID nahi mila, toh authentication possible nahi hai
        if (!$tenantId) {
            return back()->withErrors(['email' => 'Could not identify the project domain.'])->onlyInput('email');
        }

        // 2. Credentials mein tenant_id inject karein
        // Ab Auth::attempt email, password AUR tenant_id check karega (Single DB isolation).
        $credentials['tenant_id'] = $tenantId;
        
        // --- CRITICAL SECURITY FIX END ---

        // Authentication attempt
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Login successful hone par dashboard par redirect karein
            return redirect()->route('tenant.dashboard');
        }

        // Login fail hone par error ke saath wapas bhejein
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. LOGOUT PROCESS
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Logout ke baad wapas landing page par bhej dein
        return redirect()->route('tenant.landing');
    }
}