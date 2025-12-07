<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\TenantUser; // Add this

class TenantAuthController extends Controller
{
    protected $broker = 'tenant_users';
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->broker = 'tenant_users';
    }

    // ... [keep existing login/showLoginForm/logout methods] ...

    // Password reset link request form dikhana
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
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Logout के बाद wapas landing page par bhej dein
        return redirect()->route('tenant.landing');
    }
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
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('tenant.login');
    }
    // Send password reset link (MANUAL IMPLEMENTATION)
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // First, find the user
        $user = TenantUser::where('email', $request->email)
            ->where('tenant_id', tenant('id'))
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Manually create password reset token
        $token = Str::random(60);

        // Delete any existing tokens
        \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Insert new token
        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Send email manually
        try {
            // Get the current tenant's domain
            $domain = tenant('domains')->first()->domain ?? request()->getHost();

            // Build reset URL
            $resetUrl = url(route('tenant.password.reset', [
                'token' => $token,
                'email' => $request->email,
            ], false, $domain));

            // Send email (you can use Laravel Mail or your preferred method)
            \Mail::raw("Click this link to reset your password: {$resetUrl}", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Password Reset Link');
            });

            return back()->with('status', 'Password reset link sent to your email.');

        } catch (\Exception $e) {
            \Log::error('Password reset email error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send reset email. Please try again.']);
        }
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the password reset token
        $tokenData = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        // Check if token is valid and not expired
        if (!Hash::check($request->token, $tokenData->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($tokenData->created_at) > 60) {
            return back()->withErrors(['email' => 'This password reset token has expired.']);
        }

        // Find user
        $user = TenantUser::where('email', $request->email)
            ->where('tenant_id', tenant('id'))
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the used token
        \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Log the user in automatically
        Auth::login($user);

        return redirect()->route('tenant.dashboard')->with('status', 'Password reset successfully.');
    }
}
