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
    public $currentTenantId;

    public function mount()
    {
        $this->currentTenantId = tenant('id');
        $this->loadTeamsAndMembership();
    }
    
    public function loadTeamsAndMembership()
    {
        $user = Auth::user();
        
        // 1. Current Tenant ke sabhi teams fetch karein
        $this->availableTeams = Team::where('tenant_id', $this->currentTenantId)->get();
        
        // 2. Current user ki joined teams IDs nikalen
        $this->joinedTeamIds = $user->teams()->pluck('team_id')->toArray(); 
    }

    public function openJoinModal()
    {
        $this->loadTeamsAndMembership();
        $this->isJoiningModalOpen = true;
    }

    public function saveMembership()
    {
        $user = Auth::user();
        
        // Pivot table ko synchronize karein
        $user->teams()->sync($this->joinedTeamIds);

        session()->flash('success', 'Your team memberships have been updated successfully.');
        
        $this->isJoiningModalOpen = false;
        
        // Dispatch event taaki Team Switcher component/Dashboard refresh ho jaye
        $this->dispatch('team-membership-updated'); 
        
        $this->loadTeamsAndMembership(); 
    }

    public function render()
    {
        return view('livewire.user-team-joiner');
    }
}