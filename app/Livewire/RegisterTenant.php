<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tenant;
use Illuminate\Support\Str;

class RegisterTenant extends Component
{
    // Form Inputs
    public $company_name = '';
    public $subdomain = '';
    public $email = '';
    public $password = '';

    // Validation Rules
    protected $rules = [
        'company_name' => 'required|min:3',
        'subdomain' => 'required|alpha_dash|min:3|unique:domains,domain', // Check karega ke domain taken to nahi
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    // Real-time Validation (Jaise hi user type karega)
    public function updatedSubdomain()
    {
        $this->validateOnly('subdomain');
    }

    public function register()
    {
        $this->validate();

        // 1. Create Tenant (Database banegi)
        // Hum password aur email ko 'data' column me save kar rahe hain taaki baad me user create kar sakein
        $tenant = Tenant::create([
            'id' => $this->subdomain, // ID hi subdomain rakhte hain simple identification ke liye
            'trial_ends_at' => now()->addDays(30),
            'plan_status' => 'trial',
            'data' => [
                'company' => $this->company_name,
                'owner_email' => $this->email,
                'owner_password' => bcrypt($this->password), // Password encrypt karke rakhein
            ]
        ]);

        // 2. Create Domain (Link Subdomain)
        $tenant->domains()->create([
            'domain' => $this->subdomain . '.' . config('tenancy.central_domains')[2] // 'test' + '.cip-tools.de'
        ]);

        // 3. Redirect to User's Subdomain
        // Hum user ko uske naye domain par bhej denge
        $protocol = request()->secure() ? 'https://' : 'http://';
        $domain = $this->subdomain . '.' . config('tenancy.central_domains')[2];

        return redirect()->to($protocol . $domain);
    }

    public function render()
    {
        return view('livewire.register-tenant');
    }
}
