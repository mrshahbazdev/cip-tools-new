<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\TenantUser; // CRITICAL: TenantUser model import karein
class TenantUserRegistration extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        // Tenant ID ko validation ke liye use karna zaroori hai
        $tenantId = tenant('id');

        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                // CRITICAL: Email ko sirf current tenant ID ke saath unique rakhein
                Rule::unique('users')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                }),
            ],
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function register()
    {
        $this->validate();

        // CRITICAL FIX: TenantUser model use karein
        $user = TenantUser::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password, // Password ab automatic hash ho jayega (Model Cast ki wajah se)
            'tenant_id' => tenant('id'),
            'is_tenant_admin' => false,
        ]);

        // Optional: Agar aap chahte hain ki user register hote hi login ho jaye:
        // auth()->login($user);
        // return redirect()->route('tenant.dashboard');

        return redirect()->route('tenant.login')->with('status', 'Registration successful! Please log in.');
    }

    public function render()
    {
        // Fix: render()->layout(null) ki jagah, sirf view ko return karein
        return view('livewire.tenant-user-registration')
            ->with([
                'tenantId' => tenant('id'), // Tenant ID ko view mein pass karein
                'tenantName' => strtoupper(tenant('id')), // Naam ko capitalize karein
            ])
            ->layout('components.layouts.guest'); // Guest layout use karein
    }
}
