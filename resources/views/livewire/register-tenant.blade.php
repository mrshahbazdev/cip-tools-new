<div class="relative bg-gradient-to-br from-white to-slate-50 p-8 rounded-2xl shadow-2xl border border-slate-200/80">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-800 bg-clip-text text-transparent">Launch Your Project</h3>
        <p class="text-sm text-slate-500 mt-2">Claim your unique workspace in seconds</p>
    </div>

    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
            <span class="font-medium text-indigo-600">Step 1 of 3</span>
            <span>30-day free trial</span>
        </div>
        <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
            <div class="h-full w-1/3 bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
        </div>
    </div>

    <form wire:submit.prevent="register" class="space-y-5">

        <!-- Personal Information Group -->
        <div class="space-y-5 p-5 bg-gradient-to-br from-slate-50 to-white rounded-xl border border-slate-200">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-6 w-6 rounded-md bg-indigo-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-800">Personal Information</h4>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2 flex items-center justify-between">
                    <span>Your Full Name</span>
                    <span class="text-xs font-normal text-slate-400">Required</span>
                </label>
                <div class="relative">
                    <input type="text" wire:model="proposer_full_name" placeholder="John Doe"
                        class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white shadow-sm @error('proposer_full_name') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('proposer_full_name') 
                    <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Project / Company Name</label>
                <div class="relative">
                    <input type="text" wire:model="company_name" placeholder="Acme Corporation"
                        class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white shadow-sm @error('company_name') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                @error('company_name') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Workspace Configuration Group -->
        <div class="space-y-5 p-5 bg-gradient-to-br from-slate-50 to-white rounded-xl border border-slate-200">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-6 w-6 rounded-md bg-indigo-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-800">Workspace Configuration</h4>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Custom Subdomain</label>
                <div class="flex group">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live="subdomain" placeholder="yourcompany"
                            class="w-full pl-10 pr-4 py-3 border border-r-0 border-slate-300 rounded-l-xl rounded-r-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white shadow-sm @error('subdomain') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-4 border border-l-0 border-slate-300 bg-slate-100 text-slate-600 text-sm font-medium rounded-r-xl shadow-sm group-hover:bg-slate-50 transition-all duration-200">
                        .cip-tools.de
                    </span>
                </div>
                @error('subdomain') 
                    <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                @if(!$errors->has('subdomain') && !empty($subdomain))
                    <div class="flex items-center gap-2 mt-2">
                        <div class="h-5 w-5 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">Perfect! "{{ $subdomain }}.cip-tools.de" is available</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Security Group -->
        <div class="space-y-5 p-5 bg-gradient-to-br from-slate-50 to-white rounded-xl border border-slate-200">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-6 w-6 rounded-md bg-indigo-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-800">Account Security</h4>
            </div>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Owner Email</label>
                    <div class="relative">
                        <input type="email" wire:model="email" placeholder="you@company.com"
                            class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white shadow-sm @error('email') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" wire:model="password" placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white shadow-sm @error('password') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Options Group -->
        <div class="space-y-5 p-5 bg-gradient-to-br from-slate-50 to-white rounded-xl border border-slate-200">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-6 w-6 rounded-md bg-indigo-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-800">Additional Options</h4>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-start p-3 hover:bg-slate-50/50 rounded-lg transition-all duration-200">
                    <input type="checkbox" wire:model="has_bonus_scheme" id="has_bonus" 
                        class="h-5 w-5 text-indigo-600 border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 mt-0.5 shadow-sm">
                    <label for="has_bonus" class="ml-3 text-sm text-slate-700 select-none">
                        <span class="font-medium">Enable Innovation Bonus Program</span>
                        <span class="block text-slate-500 text-xs mt-1">
                            Display bonus payment options for implemented innovations to motivate contributors.
                        </span>
                    </label>
                </div>
                
                <div class="flex items-start p-3 hover:bg-slate-50/50 rounded-lg transition-all duration-200">
                    <input type="checkbox" wire:model="privacy_confirmed" id="privacy_policy" 
                        class="h-5 w-5 text-indigo-600 border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 mt-0.5 shadow-sm @error('privacy_confirmed') border-red-400 @enderror">
                    <label for="privacy_policy" class="ml-3 text-sm text-slate-700 select-none">
                        <span class="font-medium">Agree to Terms & Privacy Policy</span>
                        <span class="block text-slate-500 text-xs mt-1">
                            I confirm the Privacy Policy and validate my email address for account creation.
                        </span>
                    </label>
                </div>
                @error('privacy_confirmed') 
                    <div class="flex items-center gap-1 mt-1 text-red-500 text-sm bg-red-50 p-2 rounded-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>You must agree to the terms to continue</span>
                    </div>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white font-semibold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/40 flex justify-center items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed group">
                
                <span wire:loading.remove class="flex items-center gap-2">
                    <span>Launch 30-Day Free Trial</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>
                
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Creating Your Workspace...</span>
                </span>
            </button>

            <p class="text-center text-sm text-slate-500 mt-4 flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Full access included • No credit card required
            </p>
        </div>

    </form>

    <!-- Trial Information -->
    <div class="mt-6 pt-6 border-t border-slate-200/60">
        <div class="flex items-start gap-3 text-sm text-slate-600">
            <div class="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="font-medium text-slate-700 mb-1">What's included in your trial?</p>
                <ul class="space-y-1 text-slate-500">
                    <li class="flex items-center gap-1"><span class="h-1 w-1 rounded-full bg-slate-400"></span> Full workspace with unlimited users</li>
                    <li class="flex items-center gap-1"><span class="h-1 w-1 rounded-full bg-slate-400"></span> Custom subdomain and branding</li>
                    <li class="flex items-center gap-1"><span class="h-1 w-1 rounded-full bg-slate-400"></span> All collaboration features</li>
                    <li class="flex items-center gap-1"><span class="h-1 w-1 rounded-full bg-slate-400"></span> No setup fees or hidden costs</li>
                </ul>
            </div>
        </div>
    </div>
</div>