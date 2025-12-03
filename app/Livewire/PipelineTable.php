<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea;

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
        
        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId) // Scope to current tenant
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
        ]);
    }
}