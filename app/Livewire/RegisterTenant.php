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
    
    // --- NEW FIELDS ---
    public $has_bonus_scheme = false; // Checkbox for bonus
    public $privacy_confirmed = false; // Checkbox for policy
    public $proposer_full_name = '';   // Proposer/Admin ka full naam
    protected $rules = [
        'company_name' => 'required|min:3',
        'subdomain' => 'required|alpha_dash|min:3|unique:domains,domain|unique:tenants,id',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'proposer_full_name' => 'required|min:3',
        'has_bonus_scheme' => 'boolean', 
        'privacy_confirmed' => 'accepted', // Must be true/checked
    ];

    public function updatedSubdomain()
    {
        $this->validateOnly('subdomain');
    }

    public function register()
    {
        $this->validate(); // Validation chalaein

        // 1. Create Tenant (DB update)
        $tenant = Tenant::create([
            'id' => $this->subdomain,
            'trial_ends_at' => now()->addDays(30), // 30-day trial set ho gaya
            'plan_status' => 'trial',
            // --- NEW FIELDS SAVING ---
            'has_bonus_scheme' => $this->has_bonus_scheme, // Save bonus decision
        ]);

        // 2. Create Domain... (baaki logic same)
        $tenant->domains()->create([
            'domain' => $this->subdomain . '.cip-tools.de'
        ]);

        // 3. Create Admin User (TenantUser table)
        $user = TenantUser::create([
            'name' => $this->proposer_full_name, // Full name use karein
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'tenant_id' => $tenant->id, 
            'is_tenant_admin' => true, // Pehla user admin hi rahega
        ]);
        
        // 4. Redirect... (baaki logic same)
        $protocol = request()->secure() ? 'https://' : 'http://';
        $domain = $this->subdomain . '.cip-tools.de';
        
        return redirect()->to($protocol . $domain . '/login');
    }

    public function render()
    {
        return view('livewire.register-tenant');
    }
}
