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

    protected $listeners = ['ideaSaved' => 'render'];

    public $search = '';
    public $statusFilter = '';

    public $statuses = [
        'New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'
    ];

    public function mount()
    {
        if (!session('active_team_id') && Auth::check()) {
            $tenantUser = TenantUser::find(Auth::id());

            if ($tenantUser && $tenantUser->teams->isNotEmpty()) {
                session(['active_team_id' => $tenantUser->teams->first()->id]);
            }
        }
    }

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

    public function saveIdeaField($ideaId, $fieldName, $newValue)
    {
        $user = Auth::user();

        if ($newValue === '') {
            $newValue = null;
        }

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

        $idea = ProjectIdea::find($ideaId);
        if ($idea) {
            $idea->update([$fieldName => $newValue]);
            session()->flash('message', "{$idea->problem_short} ($fieldName) updated successfully!");
        }
    }

    public function render()
    {
        // بہتر طریقہ سے tenant_id حاصل کریں
        $user = Auth::user();
        $tenantId = $user->tenant_id ?? null;

        // اگر tenant_id نہیں ملا تو database سے related tenant تلاش کریں
        if (!$tenantId && $user instanceof TenantUser) {
            $tenantId = $user->tenant_id;
        }

        // اگر پھر بھی نہیں ملا تو fallback
        if (!$tenantId) {
            $tenantId = tenant('id');
        }

        // Debugging کے لیے temporary log
        \Log::info('PipelineTable Tenant ID:', [
            'user_id' => $user->id,
            'tenant_id' => $tenantId,
            'tenant_from_user' => $user->tenant_id,
            'tenant_from_helper' => tenant('id')
        ]);

        $activeTeamId = session('active_team_id');
        $isTenantAdmin = $user->isTenantAdmin();

        $query = ProjectIdea::query()
            ->where('tenant_id', $tenantId);

        // 1. Team Scoping
        $query->when(!$isTenantAdmin && $activeTeamId, function (Builder $query, $activeTeamId) {
            $query->where('team_id', $activeTeamId);
        });

        // 2. Dynamic Search Filter
        $query->when($this->search, function (Builder $query) {
            $query->where(function (Builder $subQuery) {
                $subQuery->where('problem_short', 'like', '%' . $this->search . '%')
                         ->orWhere('developer_notes', 'like', '%' . $this->search . '%')
                         ->orWhere('goal', 'like', '%' . $this->search . '%');
            });
        });

        // 3. Status Filter
        $query->when($this->statusFilter, function (Builder $query) {
            $query->where('status', $this->statusFilter);
        });

        // 4. Final Query Execution (Pagination)
        $ideas = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.pipeline-table', [
            'ideas' => $ideas,
            'isTenantAdmin' => $isTenantAdmin,
            'isDeveloper' => $user->isDeveloper(),
            'isWorkBee' => $user->isWorkBee(),
        ])->layout('components.layouts.guest');
    }
}
