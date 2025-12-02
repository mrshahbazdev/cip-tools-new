<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-100 min-h-screen">

    @php
        // Tenant record ko fresh load karein
        $currentTenant = \App\Models\Tenant::find(tenant('id'));
        $loggedInUser = auth()->user();
        
        // 1. Calculate Days Remaining (Final clean logic)
        $trialEndDate = $currentTenant->trial_ends_at;
        $hoursRemaining = $trialEndDate ? now()->diffInHours($trialEndDate, false) : 0;
        $cleanDaysRemaining = $hoursRemaining > 0 ? ceil($hoursRemaining / 24) : 0;
        
        if ($currentTenant->plan_status === 'active') {
            $statusText = 'Active Plan';
            $statusColor = 'text-green-600';
            $remainingText = 'Unlimited Access';
        } elseif ($cleanDaysRemaining > 0) {
            $statusText = 'Trial Period';
            $statusColor = 'text-orange-500';
            $remainingText = $cleanDaysRemaining . ' days remaining';
        } else {
            $statusText = 'Trial Expired';
            $statusColor = 'text-red-600';
            $remainingText = 'Access Blocked';
        }

        // 2. Count Total Tenant Users (Scoped)
        $totalUsers = \App\Models\TenantUser::where('tenant_id', tenant('id'))->count();
        
        // 3. Branding & Incentive Text (New Fields)
        $slogan = $currentTenant->slogan ?? 'Thought together and made together.';
        $incentive = $currentTenant->incentive_text ?? 'Please specify the type of proposer remuneration.';
    @endphp

    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <h1 class="text-xl font-extrabold text-indigo-700">
                {{ strtoupper(tenant('id')) }} WORKSPACE
            </h1>

            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-600 hidden sm:block">
                    Admin: {{ $loggedInUser->email }}
                </span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition duration-150 shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-indigo-700 text-white p-6 md:p-10 rounded-xl shadow-xl mb-8">
                <p class="text-xs font-semibold uppercase opacity-80">
                    Project Motto
                </p>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    "{{ $slogan }}"
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Collaborators</p>
                    <p class="text-4xl font-bold text-indigo-600 mt-1">
                        {{ $totalUsers }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Subscription Status</p>
                    <p class="text-xl font-bold {{ $statusColor }} mt-2">
                        <span class="text-2xl uppercase">{{ $statusText }}</span>
                    </p>
                    <p class="text-md text-gray-700 mt-1">{{ $remainingText }}</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Project Ideas Received</p>
                    <p class="text-4xl font-bold text-gray-700 mt-1">0</p>
                </div>
                
                <a href="{{ route('tenant.users.manage') }}" class="bg-indigo-600 hover:bg-indigo-700 p-6 rounded-xl shadow-lg flex items-center justify-center transition">
                    <span class="text-white font-semibold text-lg">Manage Team &rarr;</span>
                </a>
            </div>

            <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Proposer Incentive & Remuneration</h3>
                <p class="text-sm text-gray-700">
                    **Incentive:** {{ $incentive }}
                </p>
                <p class="mt-2 text-xs text-red-700 font-medium italic">
                    Note: The bonus is not provided by Cip-Tools.com but by the project manager. The project manager is fully liable for it.
                </p>
            </div>


            <div class="mt-8 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Project Settings & Billing</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <a href="/settings" class="flex items-center justify-center p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-150">
                        <span class="text-gray-700 font-medium">Configure Project Settings</span>
                    </a>
                    
                    <a href="{{ route('tenant.billing') }}" class="flex items-center justify-center p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-150">
                        <span class="text-gray-700 font-medium">Billing & Plan</span>
                    </a>
                    
                    <a href="/reports" class="flex items-center justify-center p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-150">
                        <span class="text-gray-700 font-medium">View Reports (Pending)</span>
                    </a>
                </div>
            </div>
            
        </div>
    </main>

</body>
</html>