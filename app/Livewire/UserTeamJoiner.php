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

    // --- LIFECYCLE & INITIALIZATION ---

    public function mount()
    {
        // Component load hone par data load karein
        $this->loadTeamsAndMembership();
    }
    
    public function loadTeamsAndMembership()
    {
        $tenantId = tenant('id');
        $user = Auth::user();
        
        // 1. Current Tenant ke sabhi teams fetch karein (Fresh query)
        $this->availableTeams = Team::where('tenant_id', $tenantId)->get();
        
        // 2. Current user ki joined teams IDs nikalen (Pivot table se)
        // CRITICAL FIX: Direct relationship se IDs nikalen taaki sync ho sake
        $this->joinedTeamIds = $user->teams()->pluck('team_id')->toArray(); 
    }

    // --- ACTIONS ---

    // Modal open karna (Data refresh karein)
    public function openJoinModal()
    {
        // Naya data load karein taaki newly created teams show hon
        $this->loadTeamsAndMembership(); 
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
        
        // Dispatch event taaki Team Switcher component refresh ho jaye
        $this->dispatch('team-membership-updated'); 
        
        // Data ko current state ke liye dubara load karein
        $this->loadTeamsAndMembership(); 
    }

    public function render()
    {
        return view('livewire.user-team-joiner');
    }
}