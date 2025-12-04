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
    public function mount($ideaId)
    {
        $this->ideaId = $ideaId;
        $this->idea = ProjectIdea::with('comments.user')->findOrFail($ideaId);
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
        return view('livewire.idea-detail');
    }
}