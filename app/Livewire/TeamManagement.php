<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;
use App\Models\TenantUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamManagement extends Component
{
    use WithPagination;

    // --- Team CRUD Properties ---
    public $name;
    public $teamId;
    public $isModalOpen = false;
    
    // --- Membership Management Properties ---
    public $manageMembersModalOpen = false;
    public $currentTeam;
    public $availableUsers;
    public $selectedMembers = []; 
    
    // --- User Info for Layout/Stats ---
    public $loggedInUser;
    public $totalUsers;
    public $adminUsers;
    public $standardUsers;
    public $currentTenantId; // CRITICAL: Tenant ID State property
    public $userRoles = [];
    // --- Authorization Check ---
    public function authorizeAccess()
    {
        if (! Auth::check() || ! Auth::user()->isTenantAdmin()) {
            abort(403, 'You must be the Tenant Administrator to manage teams.');
        }
    }

    // --- Validation Rules ---
    protected function rules()
    {
        $tenantId = tenant('id');
        
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('teams', 'name')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId))
                    ->ignore($this->teamId),
            ],
        ];
    }

    // --- CRUD & LIFECYCLE ACTIONS ---

    public function mount()
    {
        $this->loggedInUser = Auth::user();
        // CRITICAL FIX: Tenant ID ko component state mein CACHE karein
        $this->currentTenantId = tenant('id'); 
    }

    public function create()
    {
        $this->authorizeAccess();
        $this->resetInput();
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->authorizeAccess();
        $this->validate();

        $data = [
            'name' => $this->name,
            'tenant_id' => $this->currentTenantId, // Cached state use ho raha hai
        ];

        if ($this->teamId) {
            Team::find($this->teamId)->update($data);
            session()->flash('message', 'Team updated successfully.');
        } else {
            Team::create($data);
            session()->flash('message', 'Team created successfully.');
        }

        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function delete($id)
    {
        $this->authorizeAccess();
        Team::find($id)->delete();
        session()->flash('message', 'Team deleted successfully.');
    }

    public function edit($id)
    {
        $this->authorizeAccess();
        $team = Team::findOrFail($id);
        $this->teamId = $id;
        $this->name = $team->name;
        $this->isModalOpen = true;
    }

    // --- MEMBERSHIP MANAGEMENT METHODS ---

    // Load available users and selected members for assignment modal
    public function manageMembers($teamId)
    {
        $this->authorizeAccess();
        $this->currentTeam = Team::findOrFail($teamId);
        
        // Fetch all users for the current tenant
        // CRITICAL FIX: 'role' column ko yahan se remove karein
        $availableUsers = TenantUser::where('tenant_id', $this->currentTenantId)
                                    ->get(['id', 'name', 'email', 'is_tenant_admin']); // <-- 'role' removed
        
        // ... baaki logic same ...
        $this->userRoles = $availableUsers->keyBy('id')->map(fn ($user) => $user->role)->toArray(); // <-- Ye line bhi ghalti karegi
        
        // Final Fix: 'role' ko map karne ki jagah, default 'work-bee' se initialize karein
        $this->userRoles = $availableUsers->keyBy('id')->map(fn ($user) => 'work-bee')->toArray();

        $this->availableUsers = $availableUsers; 
        $this->manageMembersModalOpen = true;
    }
    public function saveMembers()
    {
        $this->authorizeAccess();

        $syncData = [];
        // Prepare data for the pivot table synchronization
        foreach ($this->selectedMembers as $userId) {
            // Role comes from the modal's current state ($this->userRoles)
            $role = $this->userRoles[$userId] ?? 'work-bee'; 
            $syncData[$userId] = ['role' => $role]; 
        }
        
        // 1. Synchronize the pivot table (membership and role are updated simultaneously)
        $this->currentTeam->members()->sync($syncData); 

        session()->flash('message', "Team '{$this->currentTeam->name}' membership and roles updated successfully.");
        
        $this->manageMembersModalOpen = false;
        $this->currentTeam = null;
        $this->userRoles = []; 
        $this->resetPage();
    }
    // Save members to the pivot table
    public function saveMembers()
    {
        $this->authorizeAccess();
        $syncData = [];
        foreach ($this->selectedMembers as $userId) {
            // Role ko $this->userRoles array se uthayein (jo modal se aata hai)
            $role = $this->userRoles[$userId] ?? 'work-bee'; 
            $syncData[$userId] = ['role' => $role]; // Pivot data set karein
        }
        // 1. Synchronize the pivot table (Team membership)
        $this->currentTeam->members()->sync($syncData);

        // 2. Loop through role changes and update TenantUser model
        foreach ($this->userRoles as $userId => $newRole) {
            // Hum role ko tabhi update karenge jab woh user abhi bhi selected members mein ho
            if (in_array($userId, $this->selectedMembers)) {
                $member = TenantUser::find($userId);
                if ($member && $member->role !== $newRole) {
                    $member->role = $newRole;
                    $member->save();
                }
            }
        }

        session()->flash('message', "Team '{$this->currentTeam->name}' membership and roles updated successfully.");
        
        $this->manageMembersModalOpen = false;
        $this->currentTeam = null;
        $this->userRoles = []; // Reset state
        $this->resetPage();
    }


    // --- RENDER AND HELPERS ---

    public function render()
    {
        $this->authorizeAccess();
        
        $tenantId = $this->currentTenantId;
        
        // Data for the main table (Teams)
        $teams = Team::where('tenant_id', $tenantId)
                     ->withCount(['members', 'developers', 'workBees'])
                     ->paginate(10);
        
        // Stats Calculation (for the header cards)
        $allTenantUsers = TenantUser::where('tenant_id', $tenantId)->get();
        $this->totalUsers = $allTenantUsers->count();
        $this->adminUsers = $allTenantUsers->where('is_tenant_admin', true)->count();
        $this->standardUsers = $allTenantUsers->where('is_tenant_admin', false)->count();

        return view('livewire.team-management', [
            'teams' => $teams,
            'totalUsers' => $this->totalUsers,
            'adminUsers' => $this->adminUsers,
            'standardUsers' => $this->standardUsers,
        ])->layout('components.layouts.guest');
    }

    private function resetInput()
    {
        $this->teamId = null;
        $this->name = '';
        $this->isModalOpen = false;
    }
}