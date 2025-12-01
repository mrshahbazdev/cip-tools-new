<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tenant;
use App\Models\TenantUser; // <-- CRITICAL FIX: TenantUser Model use hoga
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterTenant extends Component
{
    // ... baaki properties as is ...
    public $company_name = '';
    public $subdomain = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'company_name' => 'required|min:3',
        'subdomain' => 'required|alpha_dash|min:3|unique:domains,domain|unique:tenants,id',
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function updatedSubdomain()
    {
        $this->validateOnly('subdomain');
    }

    public function register()
    {
        // Yahan double validate ho raha hai, lekin hum isay rehne denge kyunki ye chalta hai.
        $this->validate([
            'email' => [
                'required',
                'email',
                // CRITICAL FIX: Validation abhi bhi 'users' (Central) table check karega.
                // Lekin hum isay simple rakhenge kyunki 'tenant_users' table par validation complex ho jayega.
                Rule::unique('users')->where(function ($query) {
                    return $query->where('tenant_id', $this->subdomain);
                }),
            ],
        ]);
        $this->validate();

        // 1. Create Tenant (Central DB mein record)
        $tenant = Tenant::create([
            'id' => $this->subdomain,
            'trial_ends_at' => now()->addDays(30),
            'plan_status' => 'trial',
        ]);

        // 2. Create Domain (Central DB mein record)
        $tenant->domains()->create([
            'domain' => $this->subdomain . '.cip-tools.de'
        ]);

        // 3. Create Admin User (tenant_users table mein record)
        // Yahan tenancy initialize karna zaroori nahi kyunki hum Central DB mein hi save kar rahe hain.
        // Initialization sirf DB switch ke liye tha.

        // Final Fix: TenantUser model use karein aur tenant_id field add karein
        $user = TenantUser::create([
            'name' => $this->company_name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // Password encrypt karein

            'tenant_id' => $tenant->id, // <-- FINAL FIX: Tenant ID ko explicit save karein
            'is_tenant_admin' => true, // <-- Tenant Admin set karein
        ]);

        // Optional: Yahan se tenancy end karna zaroori nahi kyunki hum switch nahi kar rahe.
        // tenancy()->end();

        // 4. Redirect
        $protocol = request()->secure() ? 'https://' : 'http://';
        $domain = $this->subdomain . '.cip-tools.de';

        return redirect()->to($protocol . $domain . '/login');
    }

    public function render()
    {
        return view('livewire.register-tenant');
    }
}
