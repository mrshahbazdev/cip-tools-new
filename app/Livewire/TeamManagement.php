<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team; // Team model
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TeamManagement extends Component
{
    use WithPagination;

    // --- Properties ---
    public $name;
    public $teamId;
    public $isModalOpen = false;
    public $loggedInUser;
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

    // --- CRUD Actions ---

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
        $this->authorizeAccess(); // Check access before rendering view

        // Teams data retrieval (Assuming necessary imports are present)
        $teams = \App\Models\Team::where('tenant_id', tenant('id'))
                                ->paginate(10);

        return view('livewire.team-management', [
            'teams' => $teams,
            // Yahan 'loggedInUser' ko bhi pass kiya ja sakta hai agar view mein use ho raha ho,
            // lekin hum seedha auth()->user() use karte hain.
        ])->layout('components.layouts.guest'); // <-- FINAL FIX: Layout added
    }

    private function resetInput()
    {
        $this->teamId = null;
        $this->name = '';
    }
}
