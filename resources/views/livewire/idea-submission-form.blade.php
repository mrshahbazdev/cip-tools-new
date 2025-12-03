<div class="max-w-4xl mx-auto py-8">

    <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-3">Submit Your Innovation Idea</h1>

    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-400 text-red-700 animate-fade-in">
            <p class="font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
    @endif
    
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-xl bg-green-100 border border-green-400 text-green-700 animate-fade-in">
            <p class="font-medium">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
            </p>
            <p class="text-sm mt-1">Your idea has been successfully added to the pipeline.</p>
        </div>
    @endif

    <form wire:submit.prevent="submitIdea" class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
        
        @php
            $activeTeam = \App\Models\Team::find(session('active_team_id'));
        @endphp
        
        <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg">
            <p class="text-sm font-semibold text-indigo-700 flex items-center gap-2">
                <i class="fas fa-users-cog"></i> Submitting to Team: 
                <span class="text-indigo-900 font-extrabold">{{ $activeTeam->name ?? 'NO TEAM SELECTED' }}</span>
            </p>
            @if(!$activeTeam)
                <p class="text-red-500 text-xs mt-1">Please select an active team in the dashboard to enable submission.</p>
            @endif
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Idea Title</label>
            <input type="text" wire:model="title" placeholder="e.g., Automate client onboarding emails"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('title') border-red-400 @enderror">
            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Problem/Pain Point</label>
            <textarea wire:model="problem_detail" rows="5" placeholder="Describe the problem, the goal, and why this idea is needed."
                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('problem_detail') border-red-400 @enderror"></textarea>
            @error('problem_detail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pain Score (1-10)</label>
            <input type="number" wire:model="pain_score" min="1" max="10" placeholder="e.g. 8 (High Pain)"
                   class="w-32 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('pain_score') border-red-400 @enderror">
            @error('pain_score') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>


        <div class="mt-8 flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center gap-2"
                    {{ !$activeTeam ? 'disabled' : '' }}>
                
                <span wire:loading.remove><i class="fas fa-paper-plane"></i> Submit Idea</span>
                <span wire:loading><i class="fas fa-spinner animate-spin"></i> Submitting...</span>
            </button>
        </div>
    </form>
</div>