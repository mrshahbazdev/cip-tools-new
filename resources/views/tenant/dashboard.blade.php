<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; top: 0; right: 0; width: 80px; height: 80px; border-radius: 50%; background: rgba(99, 102, 241, 0.05); transform: translate(30%, -30%); }
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
    </style>
</head>
<body class="antialiased min-h-screen">

    @php
        // Tenant record retrieval
        $currentTenant = \App\Models\Tenant::find(tenant('id'));
        $loggedInUser = auth()->user();
        
        // 1. Calculate Days Remaining (All expiry dates are in trial_ends_at)
        $trialEndDate = $currentTenant->trial_ends_at;
        $hoursRemaining = $trialEndDate ? now()->diffInHours($trialEndDate, false) : 0;
        $cleanDaysRemaining = $hoursRemaining > 0 ? ceil($hoursRemaining / 24) : 0;
        
        // 2. Status Determination Logic
        if ($currentTenant->plan_status === 'active') {
            $statusText = 'ACTIVE';
            $statusColor = 'bg-green-100 text-green-800';
            
            if ($trialEndDate === null) {
                $remainingText = 'Lifetime Access';
            } else {
                $remainingText = $cleanDaysRemaining . ' days remaining';
            }
            
        } elseif ($cleanDaysRemaining > 0) {
            $statusText = 'TRIAL';
            $statusColor = 'bg-orange-100 text-orange-800';
            $remainingText = $cleanDaysRemaining . ' days remaining';
        } else {
            $statusText = 'EXPIRED';
            $statusColor = 'bg-red-100 text-red-800';
            $remainingText = 'Access Blocked';
        }

        // 3. Count Total Tenant Users (Scoped)
        $totalUsers = \App\Models\TenantUser::where('tenant_id', tenant('id'))->count();
        
        // 4. Branding & Incentive Text (New Fields)
        if ($currentTenant->plan_status === 'active') {
            // Agar Active hai, toh custom user-defined values load karein
            $slogan = $currentTenant->slogan ?? 'Thought together and made together.';
            $incentive = $currentTenant->incentive_text ?? 'The incentive has not been specified yet.';
        } else {
            // Agar Trial ya Expired hai, toh Locked Message show karein
            $slogan = 'Upgrade required to customize your branding.';
            $incentive = 'Configuration is currently locked. Upgrade required.';
        }
    @endphp

    <button onclick="document.querySelector('aside').classList.toggle('hidden');" class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        <aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200 z-40">
            <div class="p-6">
                <h2 class="text-xl font-extrabold text-gray-800">{{ strtoupper(tenant('id')) }}</h2>
                <p class="text-sm text-gray-500 mt-1">Workspace</p>
            </div>
            
            <nav class="flex-1 px-4">
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Main</h3>
                    <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-50 text-indigo-700 mb-2 font-medium">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('tenant.users.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-users"></i>
                        <span>Team Management</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-lightbulb"></i>
                        <span>Project Ideas</span>
                    </a>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Settings</h3>
                    <a href="/settings" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-cog"></i>
                        <span>Project Settings</span>
                    </a>
                    <a href="{{ route('tenant.billing') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-credit-card"></i>
                        <span>Billing & Plan</span>
                    </a>
                </div>
            </nav>
            
            <div class="mt-auto p-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">Admin: {{ $loggedInUser->name ?? 'Project Admin' }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $loggedInUser->email }}</p>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="glass-card border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-lg font-semibold text-gray-800">Project Overview</h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="hidden md:flex items-center space-x-2 text-sm">
                                <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                     <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div>
                                    <div class="hidden md:block">
                                        @livewire('team-switcher') 
                                    </div>
                                    <p class="font-medium text-gray-700">{{ $loggedInUser->name ?? 'Admin' }}</p>
                                    <p class="text-gray-500">{{ $loggedInUser->email }}</p>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="h-9 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition duration-150 flex items-center space-x-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="mobile-hidden">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="gradient-header text-white p-6 md:p-10 rounded-xl shadow-xl mb-8 hover-lift">
                        <p class="text-xs font-semibold uppercase opacity-90 mb-2">
                            <i class="fas fa-quote-left mr-1"></i> Project Motto
                        </p>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight">
                            "{{ $slogan }}"
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        
                        <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">Total Collaborators</p>
                                    <p class="text-3xl font-bold text-gray-900">
                                        {{ $totalUsers }}
                                    </p>
                                </div>
                                <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-users text-indigo-600 text-lg"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-4">Current team size</p>
                        </div>

                        <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">Subscription Status</p>
                                    <span class="status-badge {{ $statusColor }} mt-2">{{ $statusText }}</span>
                                </div>
                                <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-clock text-blue-600 text-lg"></i>
                                </div>
                            </div>
                            <p class="text-md text-gray-700 mt-4 font-semibold">{{ $remainingText }}</p>
                        </div>

                        <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">Project Ideas</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                                </div>
                                <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-lightbulb text-green-600 text-lg"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-4">Submitted this month</p>
                        </div>

                        <a href="{{ route('tenant.users.manage') }}" class="glass-card p-6 rounded-2xl flex flex-col justify-center items-center bg-gradient-to-r from-indigo-500 to-indigo-600 text-white hover-lift transition-all duration-300">
                            <div class="h-12 w-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center mb-2">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <p class="font-semibold text-lg">Manage Team</p>
                            <p class="text-sm opacity-90 mt-1">Add or remove members</p>
                        </a>
                    </div>

                    <div class="glass-card p-6 rounded-2xl border-l-4 border-yellow-500 mb-8 shadow-md">
                        <div class="flex items-start">
                            <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-gift text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Proposer Incentive & Remuneration</h3>
                                <p class="text-gray-700">
                                    <strong class="font-medium">Incentive:</strong> {{ $incentive }}
                                </p>
                                <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100">
                                    <p class="text-sm text-red-700">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Note:</strong> The bonus is not provided by Cip-Tools.com but by the project manager. The project manager is fully liable for it.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Simple mobile sidebar toggle
        document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
             document.querySelector('aside').classList.toggle('hidden');
             document.querySelector('aside').classList.toggle('flex');
             document.querySelector('aside').classList.toggle('fixed');
             document.querySelector('aside').classList.toggle('inset-0');
             document.querySelector('aside').classList.toggle('z-40');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
             const sidebar = document.querySelector('aside');
             const toggleBtn = document.querySelector('.sidebar-toggle');
             
             if (window.innerWidth < 1024 && 
                 sidebar && sidebar.classList.contains('fixed') && 
                 !sidebar.contains(event.target) && 
                 toggleBtn && !toggleBtn.contains(event.target)) {
                 sidebar.classList.add('hidden');
                 sidebar.classList.remove('flex');
             }
        });
        
        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
             const cards = document.querySelectorAll('.hover-lift');
             cards.forEach(card => {
                 card.addEventListener('mouseenter', function() {
                     this.style.transition = 'all 0.3s ease';
                 });
             });
        });
    </script>

</body>
</html>