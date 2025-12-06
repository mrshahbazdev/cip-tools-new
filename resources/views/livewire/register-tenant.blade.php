<div class="relative bg-white p-6 rounded-2xl shadow-xl border border-gray-200">
    <!-- Header Section -->
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-primary-600 to-purple-600 shadow-lg mb-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Start Your 30-Day Trial</h3>
        <p class="text-sm text-gray-500 mt-1">Get your workspace in seconds</p>
    </div>

    <!-- Progress Indicator -->
    <div class="mb-6">
        <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
            <span class="font-medium text-primary-600">Step 1 of 3</span>
            <span>No credit card required</span>
        </div>
        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full w-1/3 bg-gradient-to-r from-primary-500 to-primary-400 rounded-full"></div>
        </div>
    </div>

    <form wire:submit.prevent="register" class="space-y-4">

        <!-- Compact Input Fields -->
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <div class="relative">
                    <input type="text" wire:model="proposer_full_name" placeholder="John Doe"
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 outline-none transition-all duration-200 bg-white @error('proposer_full_name') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                @error('proposer_full_name')
                    <div class="flex items-center gap-1 mt-1 text-red-500 text-xs">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                <div class="relative">
                    <input type="text" wire:model="company_name" placeholder="Acme Corp"
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 outline-none transition-all duration-200 bg-white @error('company_name') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                @error('company_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Subdomain -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Workspace URL</label>
            <div class="flex group">
                <div class="relative flex-1">
                    <input type="text" wire:model.live="subdomain" placeholder="yourcompany"
                        class="w-full pl-9 pr-3 py-2.5 border border-r-0 border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 outline-none transition-all duration-200 bg-white @error('subdomain') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-100 text-gray-600 text-sm rounded-r-lg">
                    .cip-tools.de
                </span>
            </div>
            @error('subdomain')
                <div class="flex items-center gap-1 mt-1 text-red-500 text-xs">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            @if(!$errors->has('subdomain') && !empty($subdomain))
                <div class="flex items-center gap-1.5 mt-1.5">
                    <div class="h-4 w-4 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-green-600">Available! → {{ $subdomain }}.cip-tools.de</span>
                </div>
            @endif
        </div>

        <!-- Email & Password -->
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <div class="relative">
                    <input type="email" wire:model="email" placeholder="you@company.com"
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 outline-none transition-all duration-200 bg-white @error('email') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" wire:model="password" placeholder="••••••••"
                        class="w-full pl-9 pr-9 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 outline-none transition-all duration-200 bg-white @error('password') border-red-400 focus:ring-red-500/30 @enderror">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Checkbox Options - Compact -->
        <div class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex items-start">
                <input type="checkbox" wire:model="has_bonus_scheme" id="has_bonus"
                    class="h-4 w-4 text-primary-600 border-gray-300 rounded mt-0.5 focus:ring-2 focus:ring-primary-500/30">
                <label for="has_bonus" class="ml-2 text-sm text-gray-700">
                    Enable innovation bonus program
                    <span class="block text-xs text-gray-500 mt-0.5">Motivate contributors with bonus payments</span>
                </label>
            </div>

            <div class="flex items-start">
                <input type="checkbox" wire:model="privacy_confirmed" id="privacy_policy"
                    class="h-4 w-4 text-primary-600 border-gray-300 rounded mt-0.5 focus:ring-2 focus:ring-primary-500/30 @error('privacy_confirmed') border-red-400 @enderror">
                <label for="privacy_policy" class="ml-2 text-sm text-gray-700">
                    I agree to Terms & Privacy Policy
                    <span class="block text-xs text-gray-500 mt-0.5">Required for account creation</span>
                </label>
            </div>
            @error('privacy_confirmed')
                <div class="flex items-center gap-1 text-red-500 text-xs bg-red-50 p-2 rounded">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>You must agree to the terms</span>
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-semibold py-3 rounded-lg transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/40 disabled:opacity-50 disabled:cursor-not-allowed group">

                <span wire:loading.remove class="flex items-center justify-center gap-2">
                    <span>Start Free Trial</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>

                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Creating Workspace...</span>
                </span>
            </button>

            <p class="text-center text-xs text-gray-500 mt-3 flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                No credit card • Full access • Cancel anytime
            </p>
        </div>
    </form>

    <!-- Quick Info -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">30-day free trial includes:</p>
                <ul class="text-xs text-gray-600 space-y-0.5">
                    <li class="flex items-center gap-1.5"><span class="h-1 w-1 rounded-full bg-primary-500"></span> Unlimited users & projects</li>
                    <li class="flex items-center gap-1.5"><span class="h-1 w-1 rounded-full bg-primary-500"></span> Custom subdomain</li>
                    <li class="flex items-center gap-1.5"><span class="h-1 w-1 rounded-full bg-primary-500"></span> All features included</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.querySelector('[wire\\:model="password"]');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }
</script>
