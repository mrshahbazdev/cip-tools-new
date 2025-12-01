<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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

        // User creation (Scoped to Tenant)
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // Password encrypt karein
            'tenant_id' => tenant('id'),              // User ko current tenant se jodein
            'is_tenant_admin' => false,               // Ye regular user hai, admin nahi
        ]);

        // Redirect to login page
        return redirect()->to(url('/'))->with('status', 'Registration successful! Please log in.');
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
