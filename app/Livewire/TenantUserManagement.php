<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Pagination ke liye
use App\Models\TenantUser; // TenantUser model use karein
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenantUserManagement extends Component
{
    use WithPagination; // Pagination ke liye is trait ko use karein
    
    // Form properties (Edit/Add ke liye)
    public $name, $email, $password, $is_tenant_admin;
    public $userId;
    public $isModalOpen = false;

    // Rules for adding/editing users
    protected function rules()
    {
        // CRITICAL FIX: Login successful hai, toh Auth user se tenant_id uthao
        $tenantId = auth()->user()->tenant_id; 

        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                // Rule::unique('tenant_users') check karein
                \Illuminate\Validation\Rule::unique('tenant_users')->where(function ($query) use ($tenantId) {
                    // Email ki uniqueness sirf current tenant ID ke saath check hogi.
                    return $query->where('tenant_id', $tenantId);
                })->ignore($this->userId), // Edit karte waqt current user ko ignore karein
            ],
            'password' => 'nullable|min:6',
        ];
    }
    
    // CRITICAL: Sirf Tenant Admin ko hi is page ka access ho
    public function authorizeAccess()
    {
        if (! auth()->check() || ! auth()->user()->isTenantAdmin()) {
            abort(403, 'You are not authorized to manage users in this workspace.');
        }
    }

   public function render()
    {
        $this->authorizeAccess();

        $tenantId = tenant('id');
        
        $users = TenantUser::where('tenant_id', $tenantId)
                            ->orderBy('is_tenant_admin', 'desc')
                            ->paginate(10);

        return view('livewire.tenant-user-management', [
            'users' => $users,
            'currentTenantId' => $tenantId,
        ])->layout('components.layouts.guest'); // <--- CRITICAL FIX: Explicitly set the existing guest layout
    }

    // New User Add/Edit Modal Open karna
    public function create()
    {
        $this->authorizeAccess(); // <-- ADDED
        $this->resetInput();
        $this->isModalOpen = true;
    }

    // User Delete karna
    public function delete($id)
    {
        $this->authorizeAccess(); // <-- ADDED
        TenantUser::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    // Edit ke liye data load karna
    public function edit($id)
    {
        $this->authorizeAccess(); // <-- ADDED
        $user = TenantUser::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isModalOpen = true;
    }

    // Save/Update logic
    // app/Livewire/TenantUserManagement.php

    public function store()
    {
        $this->authorizeAccess();

        // Naya user banane ke liye, validation rules ko dynamicly adjust karna hoga
        $rules = $this->rules(); // Correct validation rules fetch karein

        $data = $this->validate($rules); // Validation run karein

        // --- CRITICAL FIX START ---
        // 1. Tenant ID ko data array mein inject karein
        $data['tenant_id'] = tenant('id');
        
        // 2. is_tenant_admin flag set karein (Naya user = false)
        // Hum sirf original project owner ko admin rakhhenge.
        $data['is_tenant_admin'] = false; 
        // --- CRITICAL FIX END ---
        
        // Password handling
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($this->userId) {
            // Edit mode (password field ko ignore karein agar khali ho)
            TenantUser::find($this->userId)->update($data);
        } else {
            // Create mode
            TenantUser::create($data);
        }

        session()->flash('message', 'User saved successfully.');
        $this->isModalOpen = false;
        $this->resetInput();
    }
    
    // Helper method to reset form inputs
    private function resetInput()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->isModalOpen = false;
    }
}