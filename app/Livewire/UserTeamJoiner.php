<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\TenantUser;
use Illuminate\Support\Facades\Auth;

class UserTeamJoiner extends Component
{
    public $availableTeams;
    public $joinedTeamIds = [];
    public $isJoiningModalOpen = false;

    public function mount()
    {
        $this->loadTeamsAndMembership();
    }
    
    // Teams aur membership status ko load karein
    public function loadTeamsAndMembership()
    {
        $tenantId = tenant('id');
        $user = Auth::user();
        
        // 1. Current Tenant ke sabhi teams fetch karein
        $this->availableTeams = Team::where('tenant_id', $tenantId)->get();
        
        // 2. Current user ki joined teams IDs nikalen
        $this->joinedTeamIds = $user->teams()->pluck('team_id')->toArray();
    }

    // Modal open karna
    public function openJoinModal()
    {
        $this->loadTeamsAndMembership(); // Data refresh karein
        $this->isJoiningModalOpen = true;
    }

    // User ko selected teams mein save karna (Attach/Detach)
    public function saveMembership()
    {
        $user = Auth::user();
        
        // Pivot table ko synchronize karein
        $user->teams()->sync($this->joinedTeamIds);

        session()->flash('success', 'Your team memberships have been updated successfully.');
        $this->isJoiningModalOpen = false;
        
        // Component ko refresh karein
        $this->dispatch('team-membership-updated');
    }

    public function render()
    {
        return view('livewire.user-team-joiner');
    }
}