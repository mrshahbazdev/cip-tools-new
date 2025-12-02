<div>
<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
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
        
        <!-- Current Status -->
        <div class="mt-8 inline-flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full border border-blue-200">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-blue-800">All plans are 12-month subscriptions</span>
        </div>
    </div>

    <!-- Success Message -->
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

    <!-- No Plans Available -->
    @if($plans->isEmpty())
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 p-12 text-center">
            <div class="h-20 w-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Plans Available</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Subscription plans are not configured yet. Please contact your workspace administrator to set up available plans.
            </p>
            <a href="{{ route('tenant.dashboard') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-lg shadow-indigo-500/25">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Return to Dashboard
            </a>
        </div>
    @else
        <!-- Plans Grid -->
        <div class="grid md:grid-cols-{{ min(count($plans), 3) }} gap-8">
            @foreach($plans as $index => $plan)
                <div class="relative">
                    <!-- Recommended Badge -->
                    @if($plan->name === 'Basic' || $index === 1)
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-semibold shadow-lg">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                                Most Popular
                            </span>
                        </div>
                    @endif
                    
                    <!-- Plan Card -->
                    <div class="bg-gradient-to-br {{ $plan->name === 'Basic' || $index === 1 ? 'from-white to-indigo-50 border-2 border-indigo-500 shadow-xl shadow-indigo-500/20' : 'from-white to-gray-50 border border-gray-200' }} rounded-2xl p-8 h-full hover-lift">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold {{ $plan->name === 'Basic' || $index === 1 ? 'text-indigo-700' : 'text-gray-900' }} mb-2">
                                {{ $plan->name }}
                            </h3>
                            <div class="flex items-center justify-center gap-1 mb-4">
                                <span class="text-4xl font-bold {{ $plan->name === 'Basic' || $index === 1 ? 'text-indigo-600' : 'text-gray-900' }}">
                                    ${{ number_format($plan->price, 0) }}
                                </span>
                                <span class="text-gray-600">/{{ $plan->duration_months }} months</span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Billed annually • ${{\App\Helpers\NumberHelper::format($plan->price / 12, 2)}} per month
                            </p>
                        </div>
                        
                        <!-- Features List -->
                        <div class="mb-8">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                What's Included
                            </h4>
                            
                            <ul class="space-y-3">
                                @if($plan->features_list)
                                    @foreach(explode("\n", $plan->features_list) as $feature)
                                        @if(trim($feature))
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-700">{{ trim($feature) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="text-gray-400 italic">No features specified</li>
                                @endif
                            </ul>
                        </div>
                        
                        <!-- Plan Button -->
                        <div class="mt-auto">
                            <button wire:click="upgradePlan({{ $plan->id }})" 
                                class="w-full py-3.5 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg {{ $plan->name === 'Basic' || $index === 1 ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white hover:from-indigo-700 hover:to-indigo-600' : 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 hover:from-gray-200 hover:to-gray-300 hover:text-gray-900' }} group">
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
        
        <!-- Additional Information -->
        <div class="mt-12 bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 p-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Secure Payment</h4>
                    <p class="text-sm text-gray-600">All transactions are encrypted and secure</p>
                </div>
                
                <div class="text-center">
                    <div class="h-12 w-12 rounded-xl bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">30-Day Money Back</h4>
                    <p class="text-sm text-gray-600">Not satisfied? Get a full refund within 30 days</p>
                </div>
                
                <div class="text-center">
                    <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">24/7 Support</h4>
                    <p class="text-sm text-gray-600">Round-the-clock customer support</p>
                </div>
            </div>
        </div>
        
        <!-- Back to Dashboard -->
        <div class="mt-8 text-center">
            <a href="{{ route('tenant.dashboard') }}" 
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium transition-colors duration-200 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    @endif
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@push('scripts')
<script>
    // Plan selection animation
    document.addEventListener('livewire:load', function() {
        const planCards = document.querySelectorAll('.hover-lift');
        
        planCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
            });
        });
        
        // Success message auto-dismiss
        @if(session()->has('success'))
            setTimeout(() => {
                const successMessage = document.querySelector('[wire\\:key="success-message"]');
                if (successMessage) {
                    successMessage.style.opacity = '0';
                    successMessage.style.transform = 'translateY(-10px)';
                    successMessage.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }
            }, 5000);
        @endif
    });
</script>
@endpush
</div>