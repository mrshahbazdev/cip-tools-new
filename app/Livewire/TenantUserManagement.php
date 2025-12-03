<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TenantUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TenantUserManagement extends Component
{
    use WithPagination;
    
    // --- PROPERTIES ---
    public $name, $email, $password;
    public $userId;
    public $isModalOpen = false;
    public $currentTenantId; // Tenant ID ko state mein save karne ke liye
    
    // Delete Confirmation Modal Properties
    public $showDeleteModal = false;
    public $deleteUserId;
    public $deleteUserName;
    public $deleteUserEmail;

    // --- LIFECYCLE HOOKS ---

    // Component mount hone par tenant ID aur access check karein
    public function mount()
    {
        // CRITICAL FIX: Tenant ID ko state mein save karein
        $this->currentTenantId = tenant('id'); 
        $this->authorizeAccess(); 
    }

    // --- VALIDATION RULES ---

    protected function rules()
    {
        // Tenant ID ko state se uthayein
        $tenantId = $this->currentTenantId; 

        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                // Scoped Unique Check: Email sirf current tenant ID ke saath unique hona chahiye
                Rule::unique('tenant_users')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                })->ignore($this->userId), // Edit mode mein current user ko ignore karein
            ],
            // Password sirf naye user ke liye zaroori hai
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
        ];
    }
    
    // --- AUTHORIZATION ---

    // CRITICAL: Sirf Tenant Admin ko hi is page ka access ho
    public function authorizeAccess()
    {
        // Ye check karta hai ki user logged in hai aur isTenantAdmin hai
        if (! auth()->check() || ! auth()->user()->isTenantAdmin()) {
            abort(403, 'You are not authorized to manage users in this workspace.');
        }
    }

    // --- CRUD ACTIONS ---

    public function render()
    {
        $this->authorizeAccess();

        $tenantId = $this->currentTenantId; // State property use karein
        
        $users = TenantUser::where('tenant_id', $tenantId)
                            ->orderBy('is_tenant_admin', 'desc')
                            ->paginate(10);

        return view('livewire.tenant-user-management', [
            'users' => $users,
            // currentTenantId ko yahan pass karne ki zarurat nahi, woh $this se mil jayega.
        ]); // <-- FINAL FIX: ->layout(...) call hata diya
    }

    public function create()
    {
        $this->authorizeAccess();
        $this->resetInput();
        $this->isModalOpen = true;
    }
    
    // Delete confirmation show karein
    public function confirmDelete($id)
    {
        $this->authorizeAccess();
        
        $user = TenantUser::findOrFail($id);
        
        // Check karein ke user admin to nahi hai
        if ($user->is_tenant_admin) {
            session()->flash('error', 'Admin users cannot be deleted.');
            return;
        }
        
        $this->deleteUserId = $user->id;
        $this->deleteUserName = $user->name;
        $this->deleteUserEmail = $user->email;
        
        $this->showDeleteModal = true;
    }
    
    // Actual delete karne ka method
    public function deleteConfirmed()
    {
        $this->authorizeAccess();
        
        try {
            $user = TenantUser::findOrFail($this->deleteUserId);
            
            // Double-check: Admin user delete na ho sake
            if ($user->is_tenant_admin) {
                session()->flash('error', 'Admin users cannot be deleted.');
                $this->cancelDelete();
                return;
            }
            
            $user->delete();
            
            session()->flash('message', 'User removed successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting user: ' . $e->getMessage());
        }
        
        $this->cancelDelete();
    }
    
    // Delete cancel karne ka method
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->resetDeleteProperties();
    }
    
    // Delete properties reset karne ka method
    private function resetDeleteProperties()
    {
        $this->deleteUserId = null;
        $this->deleteUserName = null;
        $this->deleteUserEmail = null;
    }
    
    public function edit($id)
    {
        $this->authorizeAccess();
        $user = TenantUser::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isModalOpen = true;
    }

    // FINAL SAVE/UPDATE LOGIC
    public function store()
    {
        $this->authorizeAccess();
        
        // Validation run karein
        $validatedData = $this->validate(); 
        
        // --- DATA INJECTION & CLEANUP ---
        
        // 1. Tenant ID ko data array mein inject karein
        $validatedData['tenant_id'] = $this->currentTenantId; 
        
        // 2. is_tenant_admin flag set karein (Naya user default false)
        // Note: Owner ka flag alag se set hota hai, yahan hum naye users bana rahe hain
        $validatedData['is_tenant_admin'] = false; 
        
        // Password handling
        if (empty($validatedData['password'])) {
            // Edit mode mein password na hone par usay array se hata dein
            unset($validatedData['password']); 
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if ($this->userId) {
            // Edit mode - ensure is_tenant_admin is preserved
            $user = TenantUser::find($this->userId);
            $validatedData['is_tenant_admin'] = $user->is_tenant_admin;
            $user->update($validatedData);
        } else {
            // Create mode
            TenantUser::create($validatedData);
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