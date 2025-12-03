<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectIdea;
use Illuminate\Support\Facades\Auth;

class IdeaSubmissionForm extends Component
{
    // Form Inputs (Simplified fields)
    public $title = '';
    public $problem_detail = '';
    public $pain_score = 0; // Assuming initial score is 0
    
    protected $rules = [
        'title' => 'required|min:5',
        'problem_detail' => 'required|min:10',
        'pain_score' => 'required|integer|min:1|max:10',
    ];

    public function submitIdea()
    {
        $this->validate();
        
        $activeTeamId = session('active_team_id');
        $tenantId = tenant('id');
        $userId = Auth::id();

        // CRITICAL SECURITY CHECK: Check if active team session is set
        if (!$activeTeamId) {
            session()->flash('error', 'Submission Failed: Please select an active team in the dashboard to submit an idea.');
            return; 
        }

        // Idea Creation Logic (Saving data to ProjectIdea table)
        ProjectIdea::create([
            'tenant_id' => $tenantId,
            'team_id' => $activeTeamId, // Links the idea to the active team
            'name' => $this->title,
            'description' => $this->problem_detail,
            'status' => 'New', // Default starting status
            'pain_score' => $this->pain_score,
            // user_id is the submitter (implicit in ProjectIdea model if relationships are set up, 
            // but we use the authenticated user's ID for clarity)
        ]);

        session()->flash('message', 'Thank you! Your innovation idea has been submitted for review.');
        $this->reset(['title', 'problem_detail', 'pain_score']); // Form reset
        
        // Redirect user back to the pipeline table after submission
        return redirect()->route('tenant.pipeline'); 
    }

    public function render()
    {
        // CRITICAL FIX: Explicitly set the existing guest layout
        // Ye layout main header/footer ko handle karega
        return view('livewire.idea-submission-form')
            ->layout('components.layouts.guest'); 
    }
}