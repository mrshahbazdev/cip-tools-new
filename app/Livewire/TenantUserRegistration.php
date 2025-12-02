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
        // Hostname se tenant ID nikalna
        $hostname = request()->getHost(); 
        $domainRecord = \Stancl\Tenancy\Database\Models\Domain::where('domain', $hostname)->first();
        $tenantId = $domainRecord ? $domainRecord->tenant_id : null; // Current Tenant ID

        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                // CRITICAL FIX: tenant_users table mein email ki uniqueness check karein, scoped by tenant_id.
                Rule::unique('tenant_users')->where(function ($query) use ($tenantId) {
                    // Ye check sirf usi tenant_id ke liye chalta hai
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

        // Domain ke zariye Tenant record dhoondein
        $domainRecord = Domain::where('domain', $hostname)->first();

        if (!$domainRecord) {
            throw new \Exception("Could not identify project for registration on domain: " . $hostname);
        }

        $tenantModel = $domainRecord->tenant;

        // User creation (Scoped to TenantUser table)
        // CRITICAL FIX: User::create ki jagah TenantUser::create use karein
        TenantUser::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),

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
