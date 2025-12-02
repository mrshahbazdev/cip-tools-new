<div class="max-w-lg mx-auto">
    <!-- Header Section -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-xl mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Join <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">{{ strtoupper(tenant('id')) }}</span>
        </h2>
        <p class="text-gray-600">Create your account to access the workspace</p>
    </div>

    <!-- Success Message -->
    @if (session()->has('status'))
        <div class="mb-8 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200">
            <div class="flex items-start">
                <div class="h-5 w-5 rounded-full bg-green-500 flex items-center justify-center mt-0.5 mr-3 flex-shrink-0">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Registration Form Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200/80 p-8">
        <div class="mb-6 flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            All fields are required for account creation
        </div>

        <form wire:submit.prevent="register" class="space-y-6">
            <!-- Personal Information -->
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center justify-between">
                        <span>Full Name</span>
                        <span class="text-xs font-normal text-gray-400">As it appears officially</span>
                    </label>
                    <div class="relative">
                        <input type="text" wire:model="name" placeholder="John Doe" 
                            class="w-full pl-10 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white @error('name') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('name') 
                        <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" wire:model="email" placeholder="you@company.com" 
                            class="w-full pl-10 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white @error('email') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email') 
                        <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Password Section -->
            <div class="space-y-5 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" wire:model="password" placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white @error('password') border-red-400 focus:ring-red-500/30 @enderror">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password') 
                        <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" wire:model="password_confirmation" placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white/50 hover:bg-white">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-2">Password Requirements:</p>
                <ul class="text-xs text-gray-600 space-y-1">
                    <li class="flex items-center gap-2">
                        <span id="req-length" class="h-2 w-2 rounded-full bg-gray-300"></span>
                        At least 8 characters
                    </li>
                    <li class="flex items-center gap-2">
                        <span id="req-uppercase" class="h-2 w-2 rounded-full bg-gray-300"></span>
                        One uppercase letter
                    </li>
                    <li class="flex items-center gap-2">
                        <span id="req-number" class="h-2 w-2 rounded-full bg-gray-300"></span>
                        One number
                    </li>
                </ul>
            </div>

            <!-- Terms Agreement -->
            <div class="flex items-start p-4 bg-blue-50 rounded-xl border border-blue-200">
                <input type="checkbox" id="terms_agreement" class="h-5 w-5 text-indigo-600 border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500/30 focus:ring-offset-0 mt-0.5">
                <label for="terms_agreement" class="ml-3 text-sm text-gray-700 select-none">
                    I agree to the <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a> of {{ strtoupper(tenant('id')) }} workspace.
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/40 disabled:opacity-50 disabled:cursor-not-allowed group"
                    wire:loading.attr="disabled">
                    
                    <span wire:loading.remove class="flex items-center justify-center gap-2">
                        <span>Create Account</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    
                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Creating Account...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="font-semibold text-indigo-600 hover:text-indigo-500 ml-1 group">
                    Sign in here
                    <span class="inline-block group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </p>
        </div>
    </div>

    <!-- Security Footer -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Your data is encrypted and securely stored
        </p>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePasswordVisibility(fieldId) {
        const input = document.querySelector(`[wire\\:model="${fieldId}"]`);
        const eyeIcon = document.getElementById(`eye-${fieldId === 'password' ? 'password' : 'confirm'}`);
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }

    // Real-time password validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('[wire\\:model="password"]');
        
        passwordInput?.addEventListener('input', function(e) {
            const password = e.target.value;
            const lengthReq = document.getElementById('req-length');
            const uppercaseReq = document.getElementById('req-uppercase');
            const numberReq = document.getElementById('req-number');
            
            // Check length
            if (password.length >= 8) {
                lengthReq.classList.remove('bg-gray-300');
                lengthReq.classList.add('bg-green-500');
            } else {
                lengthReq.classList.remove('bg-green-500');
                lengthReq.classList.add('bg-gray-300');
            }
            
            // Check uppercase
            if (/[A-Z]/.test(password)) {
                uppercaseReq.classList.remove('bg-gray-300');
                uppercaseReq.classList.add('bg-green-500');
            } else {
                uppercaseReq.classList.remove('bg-green-500');
                uppercaseReq.classList.add('bg-gray-300');
            }
            
            // Check number
            if (/\d/.test(password)) {
                numberReq.classList.remove('bg-gray-300');
                numberReq.classList.add('bg-green-500');
            } else {
                numberReq.classList.remove('bg-green-500');
                numberReq.classList.add('bg-gray-300');
            }
        });
    });
</script>