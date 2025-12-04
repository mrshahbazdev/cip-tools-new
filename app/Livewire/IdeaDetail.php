<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectIdea;
use App\Models\IdeaComment;
use Illuminate\Support\Facades\Auth;

class IdeaDetail extends Component
{
    // Public properties
    public $idea;
    public $newComment = '';
    public $ideaId; // To receive from route parameter

    protected $rules = [
        'newComment' => 'required|min:5|max:1000',
    ];
    
    // Method to load the idea (called when route parameter is passed)
    public $ideaName; 
    public $ideaGoal; 
    public $submittedBy; 
    public $currentStatus;

    public function mount($ideaId)
    {
        $this->ideaId = $ideaId;
        // CRITICAL FIX: submitter relationship ko eager load karein
        $idea = ProjectIdea::with(['comments.user', 'submitter'])->findOrFail($ideaId); 
        $this->idea = $idea;
        
        // Data Initialization for the view (Using correct column names)
        $this->ideaName = $idea->problem_short ?? 'New Idea'; // Use the correct column name
        $this->ideaGoal = $idea->goal ?? 'No goal specified.'; 
        $this->currentStatus = $idea->status;
        $this->submittedBy = $idea->submitter->name ?? 'Admin'; // Access through submitter relationship
    }
    
    // Post new comment action
    public function postComment()
    {
        $this->validate();

        IdeaComment::create([
            'project_idea_id' => $this->idea->id,
            'tenant_user_id' => Auth::id(),
            'body' => $this->newComment,
        ]);
        
        // Refresh the idea data including new comments
        $this->idea->refresh(); 
        $this->newComment = '';
        session()->flash('message', 'Comment posted successfully!');
    }

    public function render()
    {
        return view('livewire.idea-detail')->layout('components.layouts.guest');
    }
}