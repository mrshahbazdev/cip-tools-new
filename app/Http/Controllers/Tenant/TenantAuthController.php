<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Password;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

// CRITICAL FIX: Base Traits ko use karein (These are the standard Laravel traits)
use Illuminate\Foundation\Auth\SendsPasswordResetEmails; 
use Illuminate\Foundation\Auth\ResetsPasswords; 
use Illuminate\Foundation\Auth\ThrottlesLogins;

class TenantAuthController extends Controller
{
    // FINAL FIX: In traits ko Controller mein use karein
    use SendsPasswordResetEmails, ResetsPasswords, ThrottlesLogins;
    
    // Auth system ko batayein ki konsa password broker use karna hai
    protected $broker = 'users'; 
    protected $redirectTo = '/dashboard'; 
    
    // --- LIFECYCLE ---
    public function __construct()
    {
        // Custom broker set karna zaroori hai
        $this->broker = 'users'; 
    }

    // 1. LOGIN FORM DIKHANA
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        // Isay return view('tenant.login') kar dein agar aapka login form simple hai.
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

        // Current Tenant ID ko credentials mein inject karein (SECURITY FIX)
        $tenantId = tenant('id');

        if (!$tenantId) {
            return back()->withErrors(['email' => 'Could not identify the project domain.'])->onlyInput('email');
        }

        // Credentials mein tenant_id inject karein
        $credentials['tenant_id'] = $tenantId;
        
        // Authentication attempt
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
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
    
    // Note: showLinkRequestForm, sendResetLinkEmail, showResetForm, aur resetPassword methods 
    // ab traits (SendsPasswordResetEmails, ResetsPasswords) se automatic provide ho jayenge.
}