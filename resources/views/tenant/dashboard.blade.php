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
        // Tenant and User retrieval for dashboard stats
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
    @endphp

    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <h1 class="text-xl font-bold text-indigo-700">
                {{ strtoupper(tenant('id')) }} Control Panel
            </h1>

            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-600 hidden sm:block">
                    Admin: {{ $loggedInUser->email }}
                </span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition duration-150 shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Project Overview
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Team Members</p>
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
                    <p class="text-sm font-medium text-gray-500">Storage Used</p>
                    <p class="text-4xl font-bold text-gray-700 mt-1">20 MB</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Project ID</p>
                    <p class="text-xl font-mono text-gray-700 mt-2">{{ tenant('id') }}</p>
                </div>
            </div>

            <div class="mt-10 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Quick Management</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <a href="{{ route('tenant.users.manage') }}" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Manage Users</span>
                    </a>
                    
                    <a href="/settings" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Project Settings (Pending)</span>
                    </a>
                    
                    <a href="{{ route('tenant.billing') }}" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Billing & Plan</span>
                    </a>
                </div>
            </div>
            
        </div>
    </main>

</body>
</html>