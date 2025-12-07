<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password; // Password facade ke liye zaroori

// CRITICAL TRAITS (Password Reset functionality Laravel se inherit karein)
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\ThrottlesLogins; // Optional, security ke liye

class TenantAuthController extends Controller
{
    // FINAL FIX: In traits ko Controller mein use karein
    use SendsPasswordResetEmails, ResetsPasswords, ThrottlesLogins;

    // CRITICAL: Broker set karein jise humne config/auth.php mein TenantUser model ke liye define kiya tha.
    protected $broker = 'tenant_users'; // Naya custom broker
    protected $redirectTo = '/dashboard';

    // --- LIFECYCLE ---
    public function __construct()
    {
        // Broker ko initialize karein
        $this->broker = 'tenant_users';
    }

    // 1. LOGIN FORM DIKHANA
    public function showLoginForm()
    {
        // Agar user already logged in hai (ye check CheckTrialExpiry middleware mein bhi hota hai)
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
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

        // Credentials mein tenant_id inject karein (Single DB isolation ke liye)
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

    // --- PASSWORD RESET METHODS (Traits se Inherit hote hain, lekin hum views ko dikhate hain) ---

    // Password reset link request form dikhana
    public function showLinkRequestForm()
    {
        return view('tenant.passwords.email');
    }

    // Password reset form dikhana (token aur email ke saath)
    public function showResetForm(Request $request, $token = null)
    {
        return view('tenant.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
