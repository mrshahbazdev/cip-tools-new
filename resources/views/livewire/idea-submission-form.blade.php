<div class="antialiased min-h-screen">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    @php
        $loggedInUser = auth()->user();
        $activeTeam = \App\Models\Team::find(session('active_team_id')); // Team context
    @endphp

    <button onclick="document.querySelector('aside').classList.toggle('hidden');" class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        <aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200 z-40">
            <div class="p-6">
                <h2 class="text-xl font-extrabold text-gray-800">{{ strtoupper(tenant('id')) }}</h2>
                <p class="text-sm text-gray-500 mt-1">Workspace</p>
            </div>
            
            <nav class="flex-1 px-4">
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Main Pipeline</h3>
                    
                    <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-home"></i>
                        <span>My Home</span>
                    </a>
                    <a href="/pipeline" class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-50 text-indigo-700 mb-2 font-medium">
                        <i class="fas fa-search"></i>
                        <span>Pipeline View</span>
                    </a>
                    <a href="/submit-idea" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit New Idea</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-lightbulb"></i>
                        <span>My Ideas</span>
                    </a>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Settings</h3>
                    <a href="{{ route('tenant.billing') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-credit-card"></i>
                        <span>Billing & Plan</span>
                    </a>
                </div>
            </nav>
            
            <div class="mt-auto p-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">User: {{ $loggedInUser->name ?? 'User' }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $loggedInUser->email }}</p>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="glass-card border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-lg font-semibold text-gray-800">Submit New Idea</h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="h-9 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition duration-150 flex items-center space-x-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="mobile-hidden">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-8">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">

                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-6">Innovation Submission Wizard</h1>
                            <div class="flex justify-between text-sm font-medium">
                                <span class="text-xs uppercase {{ $currentStep >= 1 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 1: Problem</span>
                                <span class="text-xs uppercase {{ $currentStep >= 2 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 2: Goal</span>
                                <span class="text-xs uppercase {{ $currentStep >= 3 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 3: Details</span>
                                <span class="text-xs uppercase {{ $currentStep >= 4 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 4: Review</span>
                            </div>
                            <div class="mt-2 h-2 bg-gray-200 rounded-full">
                                <div class="h-2 bg-indigo-600 rounded-full transition-all duration-500" style="width: {{ ($currentStep / $maxSteps) * 100 }}%"></div>
                            </div>
                        </div>

                        <form x-data="{ currentStep: @entangle('currentStep') }" wire:submit.prevent="submitIdea" class="space-y-6">
                            
                            <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg mb-8">
                                <p class="text-sm font-semibold text-indigo-700 flex items-center gap-2">
                                    <i class="fas fa-users-cog"></i> Submitting to Team: 
                                    <span class="text-indigo-900 font-extrabold">{{ $activeTeam->name ?? 'NO TEAM SELECTED' }}</span>
                                </p>
                                @if(!$activeTeam)
                                    <p class="text-red-500 text-xs mt-1">Please select an active team in the dashboard to enable submission.</p>
                                @endif
                            </div>
                            
                            <div x-show="currentStep === 1">
                                <h2 class="text-xl font-bold mb-4">Step 1: Your Problem</h2>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Describe your problem in 4-5 words</label>
                                        <input type="text" wire:model="problem_short" placeholder="e.g., Website login is difficult" class="w-full p-3 border rounded-lg">
                                        @error('problem_short') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pain Score (1-10) - How badly does this hurt?</label>
                                        <input type="number" wire:model="pain_score" min="1" max="10" placeholder="e.g. 8" class="w-24 p-3 border rounded-lg">
                                        @error('pain_score') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div x-show="currentStep === 2" style="display: none;">
                                <h2 class="text-xl font-bold mb-4">Step 2: Your Goal</h2>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">What needs to change for you to be satisfied?</label>
                                    <textarea wire:model="goal" rows="3" placeholder="Describe the desired outcome." class="w-full p-3 border rounded-lg"></textarea>
                                    @error('goal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div x-show="currentStep === 3" style="display: none;">
                                <h2 class="text-xl font-bold mb-4">Step 3: Problem Details</h2>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Describe your problem or pain point in as much detail as possible here.</label>
                                    <textarea wire:model="problem_detail" rows="6" placeholder="Provide context, examples, and affected users." class="w-full p-3 border rounded-lg"></textarea>
                                    @error('problem_detail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div x-show="currentStep === 4" style="display: none;">
                                <h2 class="text-xl font-bold mb-4">Step 4: Review & Submit</h2>
                                <div class="space-y-4">
                                    <div class="p-4 border rounded-lg bg-gray-50">
                                        <h3 class="font-semibold text-lg mb-2">Summary Review</h3>
                                        <p class="text-sm text-gray-700">Problem: <strong>{{ $problem_short }}</strong></p>
                                        <p class="text-sm text-gray-700">Goal: {{ $goal }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Email (for follow-up)</label>
                                        <input type="email" wire:model="contact_info" placeholder="Your contact email" class="w-full p-3 border rounded-lg">
                                        @error('contact_info') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-between">
                                <button type="button" wire:click="previousStep" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg transition" 
                                        x-show="currentStep > 1">
                                    &larr; Back
                                </button>
                                
                                @if($currentStep < $maxSteps)
                                    <button type="button" wire:click="nextStep" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition ml-auto">
                                        Next Step &rarr;
                                    </button>
                                @else
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition ml-auto"
                                            {{ !$activeTeam ? 'disabled' : '' }}>
                                        <span wire:loading.remove>Submit Idea</span>
                                        <span wire:loading>Submitting...</span>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

<script>
    // JS for password toggle (If needed, though not in this view)
    function togglePasswordVisibility(fieldId) {
        // ... logic ...
    }
    
    // JS for sidebar toggle logic
    document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
         document.querySelector('aside').classList.toggle('hidden');
         document.querySelector('aside').classList.toggle('flex');
         document.querySelector('aside').classList.toggle('fixed');
         document.querySelector('aside').classList.toggle('inset-0');
         document.querySelector('aside').classList.toggle('z-40');
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
         const sidebar = document.querySelector('aside');
         const toggleBtn = document.querySelector('.sidebar-toggle');
         
         if (window.innerWidth < 1024 && 
             sidebar && sidebar.classList.contains('fixed') && 
             !sidebar.contains(event.target) && 
             toggleBtn && !toggleBtn.contains(event.target)) {
             sidebar.classList.add('hidden');
             sidebar.classList.remove('flex');
         }
    });
</script>
</body>
</html>