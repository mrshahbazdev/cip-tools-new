<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tenant;
use App\Models\User; // <-- Ye User Model import karna zaroori hai
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class RegisterTenant extends Component
{
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
        $this->validate([
            'email' => [
                'required',
                'email',
                // User ko same email se dubara register hone se rokein, jab tak tenant_id alag na ho
                Rule::unique('users')->where(function ($query) {
                    return $query->where('tenant_id', $this->subdomain);
                }),
            ],
        ]);
        $this->validate();

        // 1. Create Tenant
        $tenant = Tenant::create([
            'id' => $this->subdomain,
            'trial_ends_at' => now()->addDays(30),
            'plan_status' => 'trial',
        ]);

        // 2. Create Domain
        $tenant->domains()->create([
            'domain' => $this->subdomain . '.cip-tools.de'
        ]);

        // 3. Create Admin User INSIDE Tenant Database
        // Ye magic step hai: Hum tenant ke context me switch karenge
        tenancy()->initialize($tenant);

        User::create([
            'name' => $this->company_name, // Filhal Company name hi User name hai
            'email' => $this->email,
            'password' => Hash::make($this->password), // Password encrypt karein
        ]);

        tenancy()->end(); // Wapas Central context me aa jayen

        // 4. Redirect
        $protocol = request()->secure() ? 'https://' : 'http://';
        $domain = $this->subdomain . '.cip-tools.de';

        return redirect()->to($protocol . $domain . '/login'); // Filament ka login path
    }

    public function render()
    {
        return view('livewire.register-tenant');
    }
}
