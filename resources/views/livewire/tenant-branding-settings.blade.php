<div class="max-w-4xl mx-auto py-8">

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-3">Project Branding & Settings</h1>

    <form wire:submit.prevent="saveSettings" class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Project Slogan / Motto</label>
            <input type="text" wire:model.defer="slogan" placeholder="e.g. Thought together and made together."
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('slogan') border-red-500 @enderror">
            @error('slogan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Proposer Incentive Text</label>
            <textarea wire:model.defer="incentive_text" rows="3" placeholder="Specify the type of remuneration offered (e.g., $500 bonus upon implementation)."
                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('incentive_text') border-red-500 @enderror"></textarea>
            @error('incentive_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Project Logo (Max 1MB)</label>
            <input type="file" wire:model="logo" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('logo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

            {{-- Display current logo placeholder if available --}}
            @if ($currentTenant && $currentTenant->logo_url)
                <p class="mt-2 text-xs text-gray-500">Current Logo is set.</p>
            @endif
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                Save Settings
            </button>
        </div>
    </form>
</div>