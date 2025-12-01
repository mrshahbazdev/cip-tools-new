<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100 mt-10">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Register for {{ strtoupper(tenant('id')) }}</h2>

    <form wire:submit.prevent="register" class="space-y-4">
        @if (session()->has('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" wire:model="name" placeholder="John Doe" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" wire:model="email" placeholder="user@{{ $tenantId }}.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition">
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-md disabled:opacity-50" wire:loading.attr="disabled">
            <span wire:loading.remove>Register Account</span>
            <span wire:loading>Processing...</span>
        </button>

    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Already have an account? <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-medium">Sign In here</a>
    </p>
</div>
