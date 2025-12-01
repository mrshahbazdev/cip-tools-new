<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\TenantUser; // CRITICAL: TenantUser model import karein
use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;
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

        // Hostname se tenant ID nikalna
        $hostname = request()->getHost();

        // CRITICAL FIX: Hostname se Domain record dhoondein
        $domainRecord = Domain::where('domain', $hostname)->first();

        // Check karein ki tenant mila ya nahi
        if (!$domainRecord) {
            // Agar domain record nahi mila, to ghalti wapas bhej dein
            throw new \Exception("Could not identify project for registration on domain: " . $hostname);
        }

        // Ab Domain record se tenant model fetch karein
        $tenantModel = $domainRecord->tenant;

        // User creation (Scoped to Tenant)
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),

            // CRITICAL FIX: Tenant ID ko Domain Record se set karein
            'tenant_id' => $tenantModel->id,

            'is_tenant_admin' => false,
        ]);

        // Redirect to login page
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
