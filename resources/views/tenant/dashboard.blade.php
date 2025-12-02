<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.05);
            transform: translate(30%, -30%);
        }
        
        .sidebar-toggle {
            display: none;
        }
        
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
            
            .mobile-hidden {
                display: none;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen">

    @php
        // Tenant record ko fresh load karein
        $currentTenant = \App\Models\Tenant::find(tenant('id'));
        $loggedInUser = auth()->user();
        
        // 1. Calculate Days Remaining (Final clean logic)
        $trialEndDate = $currentTenant->trial_ends_at;
        $hoursRemaining = $trialEndDate ? now()->diffInHours($trialEndDate, false) : 0;
        $cleanDaysRemaining = $hoursRemaining > 0 ? ceil($hoursRemaining / 24) : 0;
        
        if ($currentTenant->plan_status === 'active') {
            $statusText = 'Active';
            $statusColor = 'bg-green-100 text-green-800';
            $remainingText = 'Unlimited Access';
        } elseif ($cleanDaysRemaining > 0) {
            $statusText = 'Trial';
            $statusColor = 'bg-orange-100 text-orange-800';
            $remainingText = $cleanDaysRemaining . ' days remaining';
        } else {
            $statusText = 'Expired';
            $statusColor = 'bg-red-100 text-red-800';
            $remainingText = 'Access Blocked';
        }

        // 2. Count Total Tenant Users (Scoped)
        $totalUsers = \App\Models\TenantUser::where('tenant_id', tenant('id'))->count();
        
        // 3. Branding & Incentive Text (New Fields)
        $slogan = $currentTenant->slogan ?? 'Thought together and made together.';
        $incentive = $currentTenant->incentive_text ?? 'Please specify the type of proposer remuneration.';
    @endphp

    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800">{{ strtoupper(tenant('id')) }}</h2>
                <p class="text-sm text-gray-500 mt-1">Workspace</p>
            </div>
            
            <nav class="flex-1 px-4">
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Main</h3>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-50 text-indigo-700 mb-2">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('tenant.users.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2">
                        <i class="fas fa-users"></i>
                        <span>Team Management</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2">
                        <i class="fas fa-lightbulb"></i>
                        <span>Project Ideas</span>
                    </a>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Settings</h3>
                    <a href="/settings" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2">
                        <i class="fas fa-cog"></i>
                        <span>Project Settings</span>
                    </a>
                    <a href="{{ route('tenant.billing') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2">
                        <i class="fas fa-credit-card"></i>
                        <span>Billing & Plan</span>
                    </a>
                    <a href="/reports" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </div>
                
                <div class="mt-auto p-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm font-medium text-blue-800">Need help?</p>
                        <p class="text-xs text-blue-600 mt-1">Contact support 24/7</p>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="glass-card border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-lg font-semibold text-gray-800">Admin Dashboard</h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="hidden md:flex items-center space-x-2 text-sm">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">{{ $loggedInUser->name ?? 'Admin' }}</p>
                                    <p class="text-gray-500">{{ $loggedInUser->email }}</p>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <button class="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200">
                                    <i class="fas fa-bell text-gray-600"></i>
                                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                                </button>
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
                    <!-- Slogan Banner -->
                    <div class="gradient-header text-white p-6 md:p-8 rounded-2xl shadow-xl mb-8 hover-lift">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold uppercase opacity-90 mb-2">
                                    <i class="fas fa-quote-left mr-1"></i> Project Motto
                                </p>
                                <h2 class="text-2xl md:text-3xl font-bold tracking-tight">
                                    "{{ $slogan }}"
                                </h2>
                            </div>
                            <div class="hidden md:block">
                                <span class="status-badge {{ $statusColor }}">{{ $statusText }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
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
                            <p class="text-xs text-gray-500 mt-4">Active team members</p>
                        </div>

                        <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">Subscription Status</p>
                                    <p class="text-xl font-semibold text-gray-900 mt-1">
                                        {{ $remainingText }}
                                    </p>
                                    <span class="status-badge {{ $statusColor }} mt-2">{{ $statusText }}</span>
                                </div>
                                <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-blue-600 text-lg"></i>
                                </div>
                            </div>
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
                            <div class="h-12 w-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center mb-4">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <p class="font-semibold text-lg">Manage Team</p>
                            <p class="text-sm opacity-90 mt-1">Add or remove members</p>
                        </a>
                    </div>

                    <!-- Incentive Notice -->
                    <div class="glass-card p-6 rounded-2xl border-l-4 border-yellow-500 mb-8">
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

                    <!-- Quick Actions -->
                    <div class="glass-card p-6 rounded-2xl">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="/settings" class="p-5 bg-white rounded-xl border border-gray-200 hover:border-indigo-300 hover-lift flex items-center space-x-4">
                                <div class="h-12 w-12 rounded-lg bg-indigo-50 flex items-center justify-center">
                                    <i class="fas fa-cog text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Configure Project</p>
                                    <p class="text-sm text-gray-500">Update settings & preferences</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('tenant.billing') }}" class="p-5 bg-white rounded-xl border border-gray-200 hover:border-indigo-300 hover-lift flex items-center space-x-4">
                                <div class="h-12 w-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <i class="fas fa-credit-card text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Billing & Plan</p>
                                    <p class="text-sm text-gray-500">Upgrade or manage subscription</p>
                                </div>
                            </a>
                            
                            <a href="/reports" class="p-5 bg-white rounded-xl border border-gray-200 hover:border-indigo-300 hover-lift flex items-center space-x-4">
                                <div class="h-12 w-12 rounded-lg bg-green-50 flex items-center justify-center">
                                    <i class="fas fa-chart-line text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">View Reports</p>
                                    <p class="text-sm text-gray-500">Analytics & performance data</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Recent Activity Section (Optional - can be expanded) -->
                    <div class="mt-8 glass-card p-6 rounded-2xl">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">Recent Activity</h3>
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                    <i class="fas fa-user-plus text-gray-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">New team member added</p>
                                    <p class="text-sm text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                    <i class="fas fa-lightbulb text-gray-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">Project idea submitted</p>
                                    <p class="text-sm text-gray-500">Yesterday</p>
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
                sidebar.classList.contains('fixed') && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
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