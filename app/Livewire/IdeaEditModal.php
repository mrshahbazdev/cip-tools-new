<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectIdea;
use Illuminate\Support\Facades\Auth;

class IdeaEditModal extends Component
{
    public $idea;
    public $isModalOpen = false;
    
    // Form data properties
    public $problem_short, $pain_score, $cost, $time_duration_hours, $developer_notes, $priority, $prio_1, $prio_2, $status;
    public $goal;
    // State properties (for authorization display)
    public $isTenantAdmin, $isDeveloper, $isWorkBee;
    public $listeners = ['editIdea' => 'openModal'];
    protected $rules = [
        // Basic validation for the form fields
        'problem_short' => 'required|max:50',
        'goal' => 'nullable|max:255',
        'pain_score' => 'nullable|integer|min:1|max:10',
        'cost' => 'nullable|numeric',
        'time_duration_hours' => 'nullable|integer',
        'priority' => 'nullable|integer|min:1|max:10',
        'prio_1' => 'nullable|integer|min:1|max:10',
        'prio_2' => 'nullable|integer|min:1|max:10',
        'developer_notes' => 'nullable',
        'status' => 'required',
    ];

    // Opens the modal and loads data
    public function openModal(int $ideaId)
    {
        $this->idea = ProjectIdea::findOrFail($ideaId);
        
        // Load properties from the model
        $this->problem_short = $this->idea->problem_short;
        $this->pain_score = $this->idea->pain_score;
        $this->cost = $this->idea->cost;
        $this->time_duration_hours = $this->idea->time_duration_hours;
        $this->developer_notes = $this->idea->developer_notes;
        $this->priority = $this->idea->priority;
        $this->prio_1 = $this->idea->prio_1;
        $this->prio_2 = $this->idea->prio_2;
        $this->status = $this->idea->status;
        
        // Authorization check for disabling fields in the modal
        $user = Auth::user();
        $this->isTenantAdmin = $user->isTenantAdmin();
        $this->isDeveloper = $user->isDeveloper();
        $this->isWorkBee = $user->isWorkBee();
        
        $this->isModalOpen = true;
    }

    // Saves the updated data
    public function saveChanges()
    {
        // 1. Validation run
        $this->validate();
        
        // 2. Prepare data for update
        $data = $this->all();
        unset($data['idea'], $data['isModalOpen'], $data['isTenantAdmin'], $data['isDeveloper'], $data['isWorkBee']); // Exclude unnecessary properties
        
        // 3. Update the idea record
        $this->idea->update($data);

        session()->flash('message', "Idea '{$this->idea->problem_short}' updated successfully!");
        
        $this->isModalOpen = false;
        
        // Dispatch event to refresh the main table view
        $this->dispatch('ideaSaved')->to(\App\Livewire\PipelineTable::class); 
    }
    
    public function render()
    {
        return view('livewire.idea-edit-modal');
    }
}