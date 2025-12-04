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
        // Livewire state se user ko load karein (jo TenantUser model hoga)
        $user = Auth::user();

        // 1. CRITICAL DATA TYPE FIX: Convert empty strings for integer/decimal fields to NULL
        // لیکن input سے value پہلے ہی string میں آتی ہے، اس لیے مناسب type میں convert کریں
        if ($newValue === '' || $newValue === null) {
            $newValue = null;
        } else {
            // Field ke type ke mutabiq convert karein
            switch($fieldName) {
                case 'pain_score':
                case 'prio_1':
                case 'prio_2':
                case 'priority':
                case 'time_duration_hours':
                    $newValue = (int)$newValue;
                    break;
                case 'cost':
                    $newValue = (float)$newValue;
                    break;
                case 'status':
                case 'developer_notes':
                    // Strings ko as-is rakhain
                    $newValue = (string)$newValue;
                    break;
            }
        }

        // 2. Field Identification: Yellow (Work-Bee) vs Red (Developer)
        $isWorkBeeField = in_array($fieldName, ['pain_score', 'priority', 'status', 'prio_1', 'prio_2']); 
        $isDeveloperField = in_array($fieldName, ['developer_notes', 'cost', 'time_duration_hours']);
        
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
            // Flash message ke liye alert component use karein
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => "Access Denied: You do not have permission to edit the $fieldName."
            ]);
            return; 
        }
        
        // 3. Proceed with save if authorized
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            // Save the value
            $idea->update([$fieldName => $newValue]);
            
            // CRITICAL FIX: Component ko refresh karne ke bajaye, sirf specific idea ko update karein
            // Yeh page reload ya pagination reset nahi karega
            $this->dispatch('idea-updated', [
                'id' => $idea->id,
                'field' => $fieldName,
                'value' => $newValue
            ]);
            
            // Optional: Success message
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Updated successfully!"
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