<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectIdea;
use App\Models\Team; // Team Model import karein
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Rule use ho raha hai

class IdeaSubmissionForm extends Component
{
    // --- STEP 1: Problem ---
    public $problem_short = ''; 
    public $pain_score = 5;

    // --- STEP 2: Goal ---
    public $goal = '';

    // --- STEP 3: Details ---
    public $problem_detail = ''; 

    // --- STEP 4: Review ---
    public $contact_info = '';
    
    // --- UI/STATE ---
    public $currentStep = 1;
    public $maxSteps = 4;
    
    // --- CONTEXT CACHING (CRITICAL FIX) ---
    public $tenantId;
    public $activeTeamId;
    public $activeTeam; // Team model object for rendering

    // --- LIFECYCLE: Data Initialization ---
    public function mount()
    {
        // Tenant ID aur Active Team ID ko state mein cache karein
        $this->tenantId = tenant('id');
        $this->activeTeamId = session('active_team_id');
        
        // Active team object ko load karein (rendering ke liye)
        $this->activeTeam = Team::find($this->activeTeamId);
        
        // Agar user logged in hai, toh uska email default contact info ho sakta hai
        if (Auth::check()) {
            $user = Auth::user();
            $this->contact_info = $user->email;
        }
    }


    // Validation Rules per Step
    protected function rules()
    {
        // Rules ab $this->tenantId par depend kar sakte hain
        $rulesMap = [
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

        return $rulesMap[$this->currentStep] ?? [];
    }
    
    // Custom Validation for multi-step
    public function nextStep()
    {
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
        // Final Validation of Step 4
        $this->validate($this->rules()); 

        // CRITICAL SECURITY CHECK: Final check on cached state
        if (!$this->activeTeamId) {
            session()->flash('error', 'Submission Failed: Please select an active team.');
            return; 
        }

        // Idea Creation Logic (Saving data)
        ProjectIdea::create([
            'tenant_id' => $this->tenantId, // Cached ID use ho raha hai
            'team_id' => $this->activeTeamId, 
            'name' => $this->problem_short, 
            'problem_short' => $this->problem_short, 
            'goal' => $this->goal, 
            'description' => $this->problem_detail, 
            'contact_info' => $this->contact_info, 
            'status' => 'New',
            'pain_score' => $this->pain_score,
            'time_duration_hours' => null, 
            'cost' => null, 
        ]);

        session()->flash('message', 'Your innovation idea has been submitted for review.');
        
        // Redirect user back to the pipeline table after submission
        return redirect()->route('tenant.pipeline'); 
    }

    public function render()
    {
        return view('livewire.idea-submission-form')
            ->layout('components.layouts.guest');
    }
}