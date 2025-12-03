<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;
use App\Models\TenantUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TeamManagement extends Component
{
    use WithPagination;

    public $name;
    public $teamId;
    public $isModalOpen = false;
    public $loggedInUser;
    public $totalUsers;
    public $adminUsers;
    public $standardUsers;

    public function authorizeAccess()
    {
        if (! Auth::check() || ! Auth::user()->isTenantAdmin()) {
            abort(403, 'You must be the Tenant Administrator to manage teams.');
        }
    }

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

    public function mount()
    {
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
            'tenant_id' => tenant('id'),
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

    public function render()
    {
        $this->authorizeAccess();
        
        $tenantId = tenant('id');
        
        $teams = Team::where('tenant_id', $tenantId)
                     ->paginate(10);
        
        // Stats Calculation
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
    }
}