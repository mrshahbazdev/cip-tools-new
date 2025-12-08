<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea; // Zaroori model import

class PipelineTable extends Component
{
    use WithPagination;

    // Properties for filtering and sorting (Inse data aa raha hai)
    public $search = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Authorization
    public $isDeveloper = false;

    // Statuses array (from Blade view)
    public $statuses = ['New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'];


    public function mount()
    {
        $user = Auth::user();
        $this->isDeveloper = $user->isDeveloper();

        // Initial state set karein
        if (empty($this->statusFilter)) {
            $this->statusFilter = 'New'; // Default filter to 'New' as shown in snapshot
        }
    }

    // Filters ko reset karne ke liye
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter']);
        $this->statusFilter = 'New'; // Default filter set karein
        $this->resetPage(); // Pagination reset karein
    }

    // Sort function (already defined implicitly by Blade headers, but needed here)
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    // CRITICAL: Data fetch method ko update karein
    public function render()
    {
        // Start query with Tenant scope and filter by Team ID
        $query = ProjectIdea::query()
            ->where('tenant_id', tenant('id'));

        // 1. Team Scoping (Assuming session('active_team_id') is set)
        $activeTeamId = session('active_team_id');
        $query->when($activeTeamId, fn($q) => $q->where('team_id', $activeTeamId));

        // 2. Search Filter (CRITICAL)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('problem_short', 'like', '%' . $this->search . '%')
                  ->orWhere('developer_notes', 'like', '%' . $this->search . '%')
                  ->orWhere('goal', 'like', '%' . $this->search . '%');
            });
        }

        // 3. Status Filter (CRITICAL)
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // 4. Sorting
        $ideas = $query->orderBy($this->sortBy, $this->sortDirection)
                       ->paginate(15); // Example pagination limit

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
        ]);
    }
}
