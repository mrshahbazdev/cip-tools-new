<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class TeamSwitcher extends Component
{
    public $teams;
    public $activeTeamId;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            // User ki joined teams fetch karein
            $this->teams = $user->teams; 

            // Session se active team ID load karein ya default set karein
            $this->activeTeamId = session('active_team_id', $this->teams->first()->id ?? null);
            
            // Critical: Agar session mein team ID nahi hai, toh set karein
            if (!session()->has('active_team_id') && $this->activeTeamId) {
                session(['active_team_id' => $this->activeTeamId]);
            }
        }
    }

    // Team switch karne ka action
    public function switchTeam($teamId)
    {
        // Validation zaroori hai ki user us team ka member ho
        if (Auth::user()->teams->pluck('id')->contains($teamId)) {
            $this->activeTeamId = $teamId;
            session(['active_team_id' => $teamId]);
            session()->flash('message', 'Team switched successfully!');
            $this->dispatch('team-switched'); // Event fire karein
        }
    }

    public function render()
    {
        // TeamSwitcher ko sirf authenticated users ko dikhao
        if (!Auth::check()) {
            return view('livewire.team-switcher'); // Empty view render karein
        }

        return view('livewire.team-switcher');
    }
}