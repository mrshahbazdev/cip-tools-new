<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea;
use App\Models\TenantUser;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PipelineTable extends Component
{
    use WithPagination;

    // Listeners for external events (e.g., modal closure)
    protected $listeners = ['ideaSaved' => 'render'];

    // --- State Properties for Filtering ---
    public $search = '';
    public $statusFilter = '';

    // Sorting properties removed as requested.

    public $statuses = [
        'New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'
    ];

    // --- LIFECYCLE HOOKS ---

    public function mount()
    {
        // Set default active team if not already set in session
        if (!session('active_team_id') && Auth::check()) {
            $tenantUser = TenantUser::find(Auth::id());

            if ($tenantUser && $tenantUser->teams->isNotEmpty()) {
                session(['active_team_id' => $tenantUser->teams->first()->id]);
            }
        }
    }

    // Reset pagination when search or filters update
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    // --- SECURITY & IN-GRID SAVE LOGIC ---

    public function saveIdeaField($ideaId, $fieldName, $newValue)
    {
        $user = Auth::user();

        // 1. CRITICAL DATA TYPE FIX (Convert empty string to NULL)
        if ($newValue === '') {
            $newValue = null;
        }

        // 2. Authorization Check (logic uses $user->isWorkBee() etc.)
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
            session()->flash('error', "Access Denied: You do not have permission to edit the $fieldName.");
            $this->dispatch('refreshComponent');
            return;
        }

        // 3. Proceed with save
        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $idea->update([$fieldName => $newValue]);
            session()->flash('message', "{$idea->problem_short} ($fieldName) updated successfully!");
        }
    }

    // --- MAIN RENDER LOGIC (FINAL) ---

    public function render()
    {
        $tenantId = tenant('id');
        $activeTeamId = session('active_team_id');
        $user = Auth::user();

        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId)

            // 1. Team Scoping (CRITICAL)
            ->when($activeTeamId, function (Builder $query, $activeTeamId) {
                $query->where('team_id', $activeTeamId);
            })

            // 2. Dynamic Search Filter (Working now)
            ->when($this->search, function (Builder $query) {
                // Use sub-grouping for correct OR logic
                $query->where(function (Builder $subQuery) {
                    $subQuery->where('problem_short', 'like', '%' . $this->search . '%')
                             ->orWhere('developer_notes', 'like', '%' . $this->search . '%')
                             ->orWhere('goal', 'like', '%' . $this->search . '%');
                });
            })

            // 3. Status Filter (Working now)
            ->when($this->statusFilter, function (Builder $query) {
                $query->where('status', $this->statusFilter);
            })

            // 4. Default Sorting (Hardcoded to creation time - most recent first)
            ->orderBy('created_at', 'desc')

            ->paginate(15);

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,

            // Pass the permission booleans to the view
            'isTenantAdmin' => $user->isTenantAdmin(),
            'isDeveloper' => $user->isDeveloper(),
            'isWorkBee' => $user->isWorkBee(),
        ])->layout('components.layouts.guest');
    }
}
