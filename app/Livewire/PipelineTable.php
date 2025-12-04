<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea;
use App\Models\TenantUser;
use App\Models\Team; 
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
        'Reviewed',
        'Pending Pricing', 
        'Approved Budget', 
        'Implementation',
        'Done'
    ];

    // --- LIFECYCLE HOOKS ---
    
    // Set default active team if not already set in session
    public function mount()
    {
        // Agar session mein active_team_id nahi hai, toh user ki pehli joined team ko set karein
        if (!session('active_team_id') && Auth::check()) {
            $tenantUser = TenantUser::find(Auth::id()); 

            if ($tenantUser && $tenantUser->teams->isNotEmpty()) {
                // User ki pehli team ko default active team set karein
                session(['active_team_id' => $tenantUser->teams->first()->id]);
            }
        }
    }
    
    // Reset pagination when search/filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatusFilter()
    {
        $this->resetPage();
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

    // --- SECURITY & IN-GRID SAVE LOGIC ---

    public function saveIdeaField($ideaId, $fieldName, $newValue)
    {
        // User authentication
        $user = Auth::user();

        // Data type conversion
        if ($newValue === '' || $newValue === null) {
            $newValue = null;
        } else {
            switch($fieldName) {
                case 'pain_score':
                case 'prio_1':
                case 'prio_2':
                case 'priority':
                case 'time_duration_hours':
                    $newValue = is_numeric($newValue) ? (int)$newValue : null;
                    break;
                case 'cost':
                    $newValue = is_numeric($newValue) ? (float)$newValue : null;
                    break;
                case 'status':
                case 'developer_notes':
                    $newValue = (string)$newValue;
                    break;
            }
        }

        // Authorization
        $isWorkBeeField = in_array($fieldName, ['pain_score', 'priority', 'status', 'prio_1', 'prio_2']); 
        $isDeveloperField = in_array($fieldName, ['developer_notes', 'cost', 'time_duration_hours']);
        
        $isAuthorized = false;
        
        if ($user->isTenantAdmin()) {
            $isAuthorized = true;
        } elseif ($isWorkBeeField && $user->isWorkBee()) {
            $isAuthorized = true;
        } elseif ($isDeveloperField && $user->isDeveloper()) {
            $isAuthorized = true;
        }

        if (!$isAuthorized) {
            return;
        }
        
        // Save to database
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $idea->update([$fieldName => $newValue]);
            
            // CRITICAL: Koi bhi pagination reset ya state change nahi karna
            // Sirf success message show karein
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Updated successfully!'
            ]);
            
            // OPTIONAL: Agar aap ko real-time update chahiye bina page reload ke
            // to aap Livewire ke emit system use kar sakte hain
            $this->dispatch('idea-field-updated', [
                'ideaId' => $ideaId,
                'field' => $fieldName,
                'value' => $newValue
            ]);
        }
    }

    // --- MAIN RENDER LOGIC ---

    public function render()
    {
        $tenantId = tenant('id');
        $activeTeamId = session('active_team_id'); // Get active team ID from session

        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId) 
            
            // 1. Scope ideas by the active team ID (CRITICAL)
            ->when($activeTeamId, function ($query, $activeTeamId) {
                $query->where('team_id', $activeTeamId); 
            })

            // 2. Dynamic Search Filter
            ->when($this->search, function ($query) {
                // Use sub-grouping for correct OR logic
                $query->where(function ($subQuery) {
                    // FIX: Use 'problem_short' instead of 'name'
                    $subQuery->where('problem_short', 'like', '%' . $this->search . '%')
                             ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            
            // 3. Status Filter
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15); 

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
            'activeTeamId' => $activeTeamId, // Pass ID for conditional logic in view
        ])->layout('components.layouts.guest');
    }
}