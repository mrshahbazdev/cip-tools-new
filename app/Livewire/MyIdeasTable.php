<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectIdea;
use App\Models\TenantUser;
use Illuminate\Support\Facades\Auth;

class MyIdeasTable extends Component
{
    use WithPagination;

    // --- State Properties for Filtering & Sorting ---
    public $search = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public $statuses = [
        'New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'
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
        $userId = Auth::id(); // Get the authenticated user's ID
        
        $ideas = ProjectIdea::query()
            ->where('tenant_id', $tenantId) // Scope by current tenant
            
            // CRITICAL SCOPE: Filter only ideas submitted by the logged-in user
            ->where('tenant_user_id', $userId) 
            
            // Dynamic Search Filter
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('problem_short', 'like', '%' . $this->search . '%')
                             ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            
            // Status Filter
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15); 

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
            'isMyIdeasView' => true, // Flag for display logic in the view
        ])->layout('components.layouts.guest');
    }
}