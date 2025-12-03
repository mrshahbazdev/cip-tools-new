<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <style>
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); }
        .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-xl mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-4">
            Upgrade Your Workspace
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Select a plan to continue enjoying <span class="font-semibold text-indigo-600">{{ strtoupper(tenant('id')) }}</span> after trial ends
        </p>
        
        <div class="mt-8 inline-flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full border border-blue-200">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-blue-800">All memberships are for a set duration or Lifetime.</span>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="mb-8 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 animate-fade-in">
            <div class="flex items-center">
                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-green-800 text-lg">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(empty($selectedPlanId))
        {{-- SECTION 1: Plans List --}}
        
        @if($plans->isEmpty())
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 p-12 text-center">
                 <div class="h-20 w-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Plans Available</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Subscription plans are not configured yet. Please contact your workspace administrator.
                </p>
                <a href="{{ route('tenant.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-lg shadow-indigo-500/25">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Dashboard
                </a>
            </div>
        @else
            {{-- Plans Grid Display --}}
            <div class="grid md:grid-cols-{{ min(count($plans), 3) }} gap-8">
                @foreach($plans as $index => $plan)
                    <div class="relative">
                        {{-- Recommended Badge Logic (Simplified) --}}
                        @if($plan->duration_months == 12)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-semibold shadow-lg">
                                    Annual
                                </span>
                            </div>
                        @endif
                        
                        <div class="bg-gradient-to-br {{ $plan->duration_months == 12 ? 'from-white to-indigo-50 border-2 border-indigo-500 shadow-xl shadow-indigo-500/20' : 'from-white to-gray-50 border border-gray-200' }} rounded-2xl p-8 h-full hover-lift flex flex-col justify-between">
                            
                            <div class="mb-auto">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold {{ $plan->duration_months == 12 ? 'text-indigo-700' : 'text-gray-900' }} mb-2">
                                        {{ $plan->name }}
                                    </h3>
                                    <div class="flex items-center justify-center gap-1 mb-4">
                                        <span class="text-4xl font-bold {{ $plan->duration_months == 12 ? 'text-indigo-600' : 'text-gray-900' }}">
                                            @if($plan->duration_months === 0)
                                                Lifetime
                                            @else
                                                ${{ number_format($plan->price, 0) }}
                                            @endif
                                        </span>
                                        <span class="text-gray-600">
                                            @if($plan->duration_months !== 0)
                                                /{{ $plan->duration_months }} mo
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        @if($plan->duration_months !== 0)
                                            Billed in full • ${{ number_format($plan->price / $plan->duration_months, 2) }} per month
                                        @else
                                            One-time payment for perpetual access.
                                        @endif
                                    </p>
                                </div>

                                <div class="mb-8">
                                    <ul class="space-y-3">
                                        @foreach(explode("\n", $plan->features_list ?? '') as $feature)
                                            @if(trim($feature))
                                                <li class="flex items-start">
                                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-700">{{ trim($feature) }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <button wire:click.prevent="$set('selectedPlanId', {{ $plan->id }})" 
                                        class="w-full py-3.5 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg {{ $plan->duration_months == 12 ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white hover:from-indigo-700 hover:to-indigo-600' : 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 hover:from-gray-200 hover:to-gray-300 hover:text-gray-900' }} group">
                                    <span class="flex items-center justify-center gap-2">
                                        Select {{ $plan->name }}
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
    @else
        {{-- SECTION 2: Checkout Form --}}
        
        @php
            $selectedPlan = $plans->firstWhere('id', $selectedPlanId);
        @endphp

        <button wire:click="$set('selectedPlanId', null)" class="mb-4 inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Plans
        </button>
        
        <div class="w-full max-w-4xl mx-auto">
            @livewire('subscription-checkout', [
                'plan' => $selectedPlan, 
                'tenantId' => $currentTenantId
            ], key($selectedPlanId))
        </div>
        
    @endif

    <a href="{{ route('tenant.dashboard') }}" class="mt-8 block text-center text-indigo-600 hover:text-indigo-800 font-medium">
        &larr; Return to Dashboard
    </a>

</div>