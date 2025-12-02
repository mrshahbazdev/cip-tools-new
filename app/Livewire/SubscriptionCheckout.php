<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class SubscriptionCheckout extends Component
{
    // Inputs for billing (Mandatory for Invoice option)
    public $billing_name;
    public $billing_address;
    public $billing_email; // Redundant, but good practice
    public $plan;
    public $payment_method_id = 'card'; // Default to card
    public $currentTenantId;
    // Billing validation rules (Mandatory for Invoice)
    protected $rules = [
        'billing_name' => 'required|min:3',
        'billing_address' => 'required|min:10',
        'billing_email' => 'required|email',
    ];

    public function mount(MembershipPlan $plan)
    {
        // Yahan plan ki details load hongi jab component render hoga
        $this->plan = $plan;
        $this->currentTenantId = tenant('id');
        // Logged-in user ka email pre-fill karein
        $this->billing_email = Auth::user()->email; 
        $this->billing_name = Auth::user()->name;
    }
    
    public function checkout()
    {
        // Agar user 'Invoice' select karta hai, toh billing details validate karein
        if ($this->payment_method_id === 'invoice') {
            $this->validate();
        }

        // 1. Create Invoice Record (Status 'pending')
        $invoice = $this->createPendingInvoice('Invoice'); // Dummy method

        // 2. Activation Logic (Manual Activation required for Invoice)
        if ($this->payment_method_id === 'invoice') {
            session()->flash('message', 'Invoice generated. Your account will be activated manually upon payment receipt.');
            return redirect()->route('tenant.billing');
        }

        // --- Stripe / PayPal logic would go here ---

        session()->flash('error', 'Payment gateway not yet integrated.');
    }

    // Temporary method to create a pending invoice record
    private function createPendingInvoice(string $method)
    {
        // Hum abhi simple logic use kar rahe hain
        return Invoice::create([
            'tenant_id' => $this->currentTenantId,
            'membership_plan_id' => $this->plan->id,
            'billing_name' => $this->billing_name,
            'billing_email' => $this->billing_email,
            'billing_address' => $this->billing_address,
            'total_amount' => $this->plan->price,
            'payment_method' => $method,
            'status' => 'pending',
            'period_starts_at' => now(),
            'period_ends_at' => now()->addMonths($this->plan->duration_months),
        ]);
    }

    public function render()
    {
        return view('livewire.subscription-checkout');
    }
}