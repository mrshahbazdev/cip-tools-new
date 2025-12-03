<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team; 
use App\Models\TenantUser; // User stats ke liye
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TeamManagement extends Component
{
    use WithPagination;

    // --- Properties ---
    public $name;
    public $teamId;
    public $isModalOpen = false;
    public $loggedInUser; // Layout user info ke liye
    public $totalUsers;   // Stats ke liye
    public $adminUsers;   // Stats ke liye
    public $standardUsers; // Stats ke liye

    // --- Authorization Check ---
    public function authorizeAccess()
    {
        // Only Tenant Admin (project owner) can manage teams
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
                // Team name must be unique within this tenant
                Rule::unique('teams', 'name')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId))
                    ->ignore($this->teamId),
            ],
        ];
    }

    // --- CRUD Actions & Lifecycle ---

    public function mount()
    {
        // Layout aur Stats ke liye user ko load karein
        $this->loggedInUser = Auth::user(); 
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
            'tenant_id' => tenant('id'), // Scope the new team to the current tenant
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

    // --- Render and Helpers ---

    public function render()
    {
        $this->authorizeAccess();
        
        $tenantId = tenant('id');
        
        // Data for the main table (Teams)
        $teams = Team::where('tenant_id', $tenantId)
                     ->paginate(10);
        
        // --- STATS CALCULATION ---
        $allTenantUsers = TenantUser::where('tenant_id', $tenantId)->get();
        $this->totalUsers = $allTenantUsers->count();
        $this->adminUsers = $allTenantUsers->where('is_tenant_admin', true)->count();
        $this->standardUsers = $allTenantUsers->where('is_tenant_admin', false)->count();

        return view('livewire.team-management', [
            'teams' => $teams,
        ]);
    }

    private function resetInput()
    {
        $this->teamId = null;
        $this->name = '';
    }
}