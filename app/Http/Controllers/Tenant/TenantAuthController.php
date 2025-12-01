<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authentication ke liye

class TenantAuthController extends Controller
{
    // 1. LOGIN FORM DIKHANA
    public function showLoginForm()
    {
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

        // Authentication attempt
        // Tenancy middleware ki wajah se ye sirf current tenant ki DB mein dhoondega
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Login successful hone par dashboard par redirect karein
            return redirect()->intended(route('tenant.dashboard'));
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
