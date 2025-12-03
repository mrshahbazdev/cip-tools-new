<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // File upload ke liye
use App\Models\Tenant;
use Illuminate\Support\Facades\Storage;

class TenantBrandingSettings extends Component
{
    use WithFileUploads; // Logo upload ke liye zaroori

    public $slogan;
    public $incentive_text;
    public $logo; // For temporary file upload
    public $currentTenant;

    // Authorization check
    public function authorizeAccess(): bool
    {
        $tenant = tenant();
        // Access sirf tab milega jab plan 'active' ho aur login ho
        return auth()->check() && $tenant && $tenant->is_active; 
    }
    
    public function mount()
    {
        // Agar authorized nahi hai, toh 403 error de dein
        if (!$this->authorizeAccess()) {
             abort(403, 'Upgrade required to access branding settings.');
        }

        // Current Tenant data load karein
        $this->currentTenant = Tenant::find(tenant('id'));
        $this->slogan = $this->currentTenant->slogan;
        $this->incentive_text = $this->currentTenant->incentive_text;
    }

    protected $rules = [
        'slogan' => 'required|max:255',
        'incentive_text' => 'nullable|max:1000',
        'logo' => 'nullable|image|max:1024', // 1MB limit
    ];

    public function saveSettings()
    {
        $this->validate();

        $updateData = [
            'slogan' => $this->slogan,
            'incentive_text' => $this->incentive_text,
        ];

        // Logo Upload Logic
        if ($this->logo) {
            // Logo ko public storage mein store karein
            $path = $this->logo->store('logos', 'public'); 
            $updateData['logo_url'] = Storage::url($path);
        }

        // Database update
        $this->currentTenant->update($updateData);

        session()->flash('success', 'Branding settings updated successfully!');
        
        // Refresh the page
        return redirect()->route('tenant.settings');
    }

    public function render()
    {
        // Ensure data is passed to the view for the full layout
        return view('livewire.tenant-branding-settings')
            ->with([
                'loggedInUser' => auth()->user(),
                'currentTenant' => $this->currentTenant,
            ])
            ->layout('components.layouts.guest'); 
    }
}