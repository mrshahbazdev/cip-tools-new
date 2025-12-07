<div class="pt-20">
    <div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow-2xl border border-gray-200">

        <h2 class="text-3xl font-bold text-indigo-700 mb-2">Project Setup Wizard</h2>
        <p class="text-gray-600 mb-8">Configure your application settings and database connection.</p>

        @if (session()->has('success'))
            <div class="mb-4 p-4 rounded-md bg-green-100 text-green-700 font-medium">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-4 rounded-md bg-red-100 text-red-700 font-medium">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="submitSetup" class="space-y-6">

            <div>
                <label class="block text-sm font-medium text-gray-700">Application URL (APP_URL)</label>
                <input type="url" wire:model="appUrl" class="mt-1 w-full p-3 border rounded-lg @error('appUrl') border-red-500 @enderror" placeholder="https://cip-tools.de">
                @error('appUrl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Central Base Domain (TENANCY_CENTRAL_DOMAIN)</label>
                <input type="text" wire:model="centralDomain" class="mt-1 w-full p-3 border rounded-lg @error('centralDomain') border-red-500 @enderror" placeholder="cip-tools.de">
                @error('centralDomain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <h3 class="text-xl font-semibold pt-4 border-t">Database Configuration</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700">Database Host</label>
                <input type="text" wire:model="dbHost" class="mt-1 w-full p-3 border rounded-lg" readonly>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Database Name</label>
                <input type="text" wire:model="dbDatabase" class="mt-1 w-full p-3 border rounded-lg @error('dbDatabase') border-red-500 @enderror">
                @error('dbDatabase') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Database Username</label>
                <input type="text" wire:model="dbUsername" class="mt-1 w-full p-3 border rounded-lg @error('dbUsername') border-red-500 @enderror">
                @error('dbUsername') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Database Password</label>
                <input type="password" wire:model="dbPassword" class="mt-1 w-full p-3 border rounded-lg">
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150">
                Configure & Run Setup
            </button>
        </form>
    </div>
</div>
