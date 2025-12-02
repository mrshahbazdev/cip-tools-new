<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MembershipPlan; // Model import karein

class BillingPlans extends Component
{
    public $plans;
    public $selectedPlanId = null;
    // Component mount hone par plans ko fetch karein
    public function mount()
    {
        $this->plans = MembershipPlan::orderBy('price')->get();
    }
    
    // Upgrade action (Abhi ye sirf placeholder hai)
    public function upgradePlan($planId)
    {
        // Yahan future mein payment logic/redirect aayega
        session()->flash('success', 'Plan selection is ready for payment gateway setup!');
    }

    public function render()
    {
        return view('livewire.billing-plans')
            // CRITICAL FIX: Explicitly set the existing guest layout
            ->layout('components.layouts.guest'); 
    }
}