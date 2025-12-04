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

    // --- New properties for inline editing ---
    public $statuses = [];
    public $painScores = [];
    public $developerNotes = [];
    public $costs = [];
    public $timeDurations = [];
    public $prio1 = [];
    public $prio2 = [];
    public $priorities = [];

    // --- Role-based status options ---
    public $statusOptions = [
        'New', 
        'Reviewed',
        'Pending Pricing', 
        'Approved Budget', 
        'Implementation',
        'Done'
    ];

    // --- LIFECYCLE HOOKS ---
    
    public function mount()
    {
        if (!session('active_team_id') && Auth::check()) {
            $tenantUser = TenantUser::find(Auth::id()); 
            if ($tenantUser && $tenantUser->teams->isNotEmpty()) {
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

    // --- AUTOSAVE LOGIC FOR INLINE EDITING ---
    
    public function updated($property, $value)
    {
        // Check which property was updated and save accordingly
        $parts = explode('.', $property);
        
        if (count($parts) === 2) {
            $fieldType = $parts[0]; // e.g., 'statuses', 'painScores'
            $ideaId = $parts[1]; // e.g., '4'
            
            // Map field type to database field name
            $fieldMap = [
                'statuses' => 'status',
                'painScores' => 'pain_score',
                'developerNotes' => 'developer_notes',
                'costs' => 'cost',
                'timeDurations' => 'time_duration_hours',
                'prio1' => 'prio_1',
                'prio2' => 'prio_2',
                'priorities' => 'priority',
            ];
            
            if (isset($fieldMap[$fieldType])) {
                $dbField = $fieldMap[$fieldType];
                $this->saveField($ideaId, $dbField, $value);
            }
        }
    }
    
    protected function saveField($ideaId, $fieldName, $newValue)
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
            // Reset the value if not authorized
            $this->resetField($ideaId, $fieldName);
            return;
        }
        
        // Save to database
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $idea->update([$fieldName => $newValue]);
            
            // Optional: Show success message
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Updated successfully!'
            ]);
        }
    }
    
    protected function resetField($ideaId, $fieldName)
    {
        // Reset the field value from database
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $fieldMap = [
                'status' => 'statuses',
                'pain_score' => 'painScores',
                'developer_notes' => 'developerNotes',
                'cost' => 'costs',
                'time_duration_hours' => 'timeDurations',
                'prio_1' => 'prio1',
                'prio_2' => 'prio2',
                'priority' => 'priorities',
            ];
            
            if (isset($fieldMap[$fieldName])) {
                $property = $fieldMap[$fieldName];
                $this->{$property}[$ideaId] = $idea->{$fieldName};
            }
        }
    }

    // --- MAIN RENDER LOGIC ---

    public function render()
    {
        $tenantId = tenant('id');
        $activeTeamId = session('active_team_id');

        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId) 
            ->when($activeTeamId, function ($query, $activeTeamId) {
                $query->where('team_id', $activeTeamId); 
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('problem_short', 'like', '%' . $this->search . '%')
                             ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);
            
        // Initialize the edit arrays with current values
        foreach ($ideas as $idea) {
            $this->statuses[$idea->id] = $idea->status ?? '';
            $this->painScores[$idea->id] = $idea->pain_score ?? '';
            $this->developerNotes[$idea->id] = $idea->developer_notes ?? '';
            $this->costs[$idea->id] = $idea->cost ?? '';
            $this->timeDurations[$idea->id] = $idea->time_duration_hours ?? '';
            $this->prio1[$idea->id] = $idea->prio_1 ?? '';
            $this->prio2[$idea->id] = $idea->prio_2 ?? '';
            $this->priorities[$idea->id] = $idea->priority ?? '';
        }

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
            'activeTeamId' => $activeTeamId,
        ])->layout('components.layouts.guest');
    }
}