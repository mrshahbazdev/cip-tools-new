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
        $tenantId = tenant('id');
        
        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                // Unique check (current user ko ignore karein agar edit ho raha hai)
                Rule::unique('tenant_users')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                })->ignore($this->userId),
            ],
            'password' => 'nullable|min:6', // Password optional hai agar edit kar rahe hon
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
    public function store()
    {
        $this->authorizeAccess();
        $data = $this->validate();
        
        if ($this->password === '') {
            unset($data['password']); // Agar password khali hai toh update na karein
        } else {
            $data['password'] = Hash::make($this->password);
        }

        $data['tenant_id'] = tenant('id');
        $data['is_tenant_admin'] = ($this->userId === null); // Pehla user admin tha, naya user regular hoga

        if ($this->userId) {
            TenantUser::find($this->userId)->update($data);
        } else {
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