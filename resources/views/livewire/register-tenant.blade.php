<div class="relative bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-900">Create Your Project</h3>
        <p class="text-sm text-slate-500">Claim your unique subdomain URL instantly.</p>
    </div>

    <form wire:submit.prevent="register" class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Project Name</label>
            <input type="text" wire:model="company_name" placeholder="e.g. Acme Corp"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50 @error('company_name') border-red-500 @enderror">
            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Desired Subdomain</label>
            <div class="flex">
                <input type="text" wire:model.live="subdomain" placeholder="acme"
                    class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50 @error('subdomain') border-red-500 @enderror">
                <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-100 text-gray-500 text-sm rounded-r-lg">
                    .cip-tools.de
                </span>
            </div>
            @error('subdomain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            @if(!$errors->has('subdomain') && !empty($subdomain))
                <span class="text-green-600 text-xs flex items-center mt-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Subdomain is available!
                </span>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Owner Email</label>
            <input type="email" wire:model="email" placeholder="you@company.com"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50 @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" wire:model="password" placeholder="********"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50 @error('password') border-red-500 @enderror">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-indigo-200/50 flex justify-center items-center gap-2 disabled:opacity-50 disabled:cursor-wait">

            <span wire:loading.remove>Start Free Trial</span>
            <span wire:loading class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Creating Project...
            </span>
            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

    </form>

    <p class="text-center text-xs text-slate-400 mt-4">
        By creating an account, you agree to our Terms & Conditions.
    </p>
</div>
