<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea;
use App\Models\TenantUser;
use App\Models\Team; // Import Team model
use Illuminate\Support\Facades\Auth;
class PipelineTable extends Component
{
    use WithPagination;

    // --- State Properties for Filtering & Sorting ---
    public $search = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // --- Role-based status options ---
    public $statuses = [
        'New', 
        'Pending Pricing', 
        'Approved Budget', 
        'Implementation',
        'Done'
    ];
    public function mount()
    {
        // Agar session mein active_team_id nahi hai, toh user ki pehli joined team ko set karein
        if (!session('active_team_id') && Auth::check()) {
            $user = Auth::user();
            
            // Ensure user is loaded as TenantUser to access teams() relation
            $tenantUser = TenantUser::find(Auth::id()); 

            if ($tenantUser && $tenantUser->teams->isNotEmpty()) {
                // User ki pehli team ko default active team set karein
                session(['active_team_id' => $tenantUser->teams->first()->id]);
            }
        }
    }
    // --- LIFECYCLE HOOKS ---
    
    // Reset pagination when search/filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    public function saveIdeaField($ideaId, $fieldName, $newValue)
    {
        // Livewire state se user ko load karein (jo TenantUser model hoga)
        $user = Auth::user(); 

        // Field Identification: Yellow (Work-Bee) vs Red (Developer)
        $isWorkBeeField = in_array($fieldName, ['pain_score', 'priority', 'status', 'prio_1', 'prio_2']); // PRIO 1 & 2 are Work-Bee fields
        $isDeveloperField = in_array($fieldName, ['developer_notes', 'cost', 'time_duration_hours', 'loesung']); // Assuming 'loesung' is mapped to developer_notes
        
        $isAuthorized = false;

        // --- AUTHORIZATION CHECK ---
        if ($user->isTenantAdmin()) {
            $isAuthorized = true; // Admin can edit everything
        } elseif ($isWorkBeeField && $user->isWorkBee()) {
            $isAuthorized = true; // Work-Bee can edit yellow fields
        } elseif ($isDeveloperField && $user->isDeveloper()) {
            $isAuthorized = true; // Developer can edit red fields
        }

        if (!$isAuthorized) {
            session()->flash('error', "Access Denied: You do not have permission to edit the $fieldName.");
            // This forces the component to reload the original data, discarding unauthorized changes
            $this->dispatch('refreshComponent'); 
            return; 
        }
        
        // Proceed with save if authorized
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $idea->update([$fieldName => $newValue]);
            session()->flash('message', "{$idea->name} ($fieldName) updated successfully!");
        }
    }
    // Sort function called when a column header is clicked
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    // --- MAIN RENDER LOGIC ---
    public function render()
    {
        $tenantId = tenant('id');
        $activeTeamId = session('active_team_id'); // <-- Get active team ID from session

        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId) // Scope to current tenant
            
            // --- CRITICAL FIX: Scope ideas by the active team ID ---
            ->when($activeTeamId, function ($query, $activeTeamId) {
                // Filter ideas by the currently selected team
                $query->where('team_id', $activeTeamId); 
            })
            // -------------------------------------------------------

            ->when($this->search, function ($query) {
                // Dynamic Live Search (Name or Description)
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                // Filter by Status
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15); // Pagination setup

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
        ])->layout('components.layouts.guest');
    }
}