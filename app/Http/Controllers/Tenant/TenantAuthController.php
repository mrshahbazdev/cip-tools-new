<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

// UPDATED: Laravel 12 (Laravel 11) uses new namespace for auth traits
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TenantAuthController extends Controller
{
    protected $broker = 'tenant_users';
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->broker = 'tenant_users';
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $tenantId = tenant('id');

        if (!$tenantId) {
            return back()->withErrors(['email' => 'Could not identify the project domain.'])->onlyInput('email');
        }

        $credentials['tenant_id'] = $tenantId;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('tenant.dashboard');
        }

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

        return redirect()->route('tenant.landing');
    }

    // --- PASSWORD RESET METHODS ---

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

    // Send password reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::broker($this->broker)->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Password::broker($this->broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('tenant.login')->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }
}
