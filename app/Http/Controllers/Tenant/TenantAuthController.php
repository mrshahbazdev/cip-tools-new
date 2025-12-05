<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class TenantAuthController extends Controller
{
    protected $broker = 'users'; 
    protected $redirectTo = '/dashboard';
    
    // --- LIFECYCLE ---
    public function __construct()
    {
        $this->broker = 'users';
    }

    // 1. LOGIN FORM DIKHANA
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('tenant.login'); 
    }

    // 2. LOGIN PROCESS (FORM SUBMIT)
    public function login(Request $request)
    {
        // Throttle login attempts
        $this->ensureIsNotRateLimited($request);

        // Validation check
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Current Tenant ID ko credentials mein inject karein
        $tenantId = tenant('id');

        if (!$tenantId) {
            return back()->withErrors(['email' => 'Could not identify the project domain.'])->onlyInput('email');
        }

        // Credentials mein tenant_id inject karein
        $credentials['tenant_id'] = $tenantId;
        
        // Authentication attempt
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            return redirect()->route('tenant.dashboard');
        }

        // Increment failed attempts
        RateLimiter::hit($this->throttleKey($request));

        // Login fail hone par error ke saath wapas bhejein
        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }
    
    // 3. LOGOUT PROCESS
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.landing');
    }
    
    // --- PASSWORD RESET FUNCTIONALITY ---
    
    // Show link request form
    public function showLinkRequestForm()
    {
        return view('tenant.auth.passwords.email');
    }
    
    // Send reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $status = Password::broker($this->broker)->sendResetLink(
            $request->only('email')
        );
        
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    
    // Show reset form
    public function showResetForm(Request $request, $token = null)
    {
        return view('tenant.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    
    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        
        $status = Password::broker($this->broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                
                $user->save();
                
                event(new PasswordReset($user));
                
                Auth::login($user);
            }
        );
        
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('tenant.dashboard')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
    
    // --- RATE LIMITING METHODS ---
    
    protected function ensureIsNotRateLimited(Request $request)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
    
    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }
}