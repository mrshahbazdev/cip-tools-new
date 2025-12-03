<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectIdea;
use Illuminate\Support\Facades\Auth;

class IdeaSubmissionForm extends Component
{
    // --- STEP 1: Problem ---
    public $problem_short = ''; // Previously 'title'
    public $pain_score = 5;

    // --- STEP 2: Goal ---
    public $goal = '';

    // --- STEP 3: Details ---
    public $problem_detail = ''; // Previously 'description'

    // --- STEP 4: Review ---
    public $contact_info = ''; // User's email
    
    // --- UI/STATE ---
    public $currentStep = 1;
    public $maxSteps = 4;

    // Validation Rules per Step
    protected function rules()
    {
        // Yahan saare steps ki rules hain, lekin hum sirf current step return karenge.
        $allRules = [
            1 => [
                'problem_short' => 'required|min:4|max:50',
                'pain_score' => 'required|integer|min:1|max:10',
            ],
            2 => [
                'goal' => 'required|min:10|max:255',
            ],
            3 => [
                'problem_detail' => 'required|min:20',
            ],
            4 => [
                'contact_info' => 'required|email',
            ],
        ];

        // Sirf current step ke rules return karein
        return $allRules[$this->currentStep] ?? [];
    }
    
    // Custom Validation for multi-step
    public function nextStep()
    {
        // CRITICAL FIX: Explicitly call validate() with the rules() method.
        $this->validate($this->rules()); 

        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;
        }
    }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submitIdea()
    {
        // Final Validation of Step 4 (Review)
        $this->validate(); 

        $activeTeamId = session('active_team_id');
        $tenantId = tenant('id');
        
        if (!$activeTeamId) {
            session()->flash('error', 'Submission Failed: Please select an active team.');
            return; 
        }

        // Idea Creation Logic (Saving data)
        ProjectIdea::create([
            'tenant_id' => $tenantId,
            'team_id' => $activeTeamId, 
            'name' => $this->problem_short, // Mapping short problem to 'name' for pipeline display
            'problem_short' => $this->problem_short, // New Field
            'goal' => $this->goal, // New Field
            'description' => $this->problem_detail, // Using detail for description
            'contact_info' => $this->contact_info, // New Field
            'status' => 'New',
            'pain_score' => $this->pain_score,
        ]);

        session()->flash('message', 'Your innovation idea has been submitted for review.');
        
        // Redirect user back to the pipeline table after submission
        return redirect()->route('tenant.pipeline'); 
    }

    public function render()
    {
        // Active team display logic
        $activeTeam = \App\Models\Team::find(session('active_team_id'));
        
        return view('livewire.idea-submission-form', [
            'activeTeam' => $activeTeam
        ])->layout('components.layouts.guest');
    }
}