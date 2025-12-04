<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | {{ tenant('id') }}</title>
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
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }
        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        .user-avatar {
             background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
        @media (max-width: 1024px) { .sidebar-toggle { display: block !important; } .mobile-hidden { display: none; } }
    </style>
</head>
<body class="antialiased">

    @php
        $loggedInUser = auth()->user();
        
        // 1. Fetch TenantUser Model (for relationships and ID)
        $tenantUser = \App\Models\TenantUser::find(auth()->id());
        $activeTeamId = session('active_team_id');
        $activeTeam = \App\Models\Team::find($activeTeamId);

        // 2. Calculate Stats (Scoped to current user)
        $teamsJoined = $tenantUser->teams->count();
        $ideasSubmitted = \App\Models\ProjectIdea::where('tenant_id', tenant('id'))
                            ->where('tenant_user_id', $loggedInUser->id) // Assuming user_id is submitter ID
                            ->count();
        $ideasInProgress = \App\Models\ProjectIdea::where('tenant_id', tenant('id'))
                             ->where('tenant_user_id', $loggedInUser->id)
                             ->whereIn('status', ['Pending Pricing', 'Implementation'])
                             ->count();
    @endphp

    <div class="flex min-h-screen">
        <aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200/60 z-40">
            <div class="p-8 border-b border-gray-200/60">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-lightbulb text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ strtoupper(tenant('id')) }}</h2>
                        <p class="text-sm text-gray-500">Innovation Hub</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 p-6">
                <div class="space-y-2">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3 tracking-wider pl-2">Navigation</h3>
                    <a href="/dashboard" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 text-indigo-700 font-medium hover-lift">
                        <i class="fas fa-home"></i>
                        <span>My Home</span>
                    </a>
                    <a href="/pipeline" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift">
                        <i class="fas fa-search"></i>
                        <span>Pipeline View</span>
                    </a>
                    <a href="/submit-idea" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit New Idea</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift">
                        <i class="fas fa-lightbulb"></i>
                        <span>My Ideas ({{ $ideasSubmitted }})</span>
                    </a>
                </div>
            </nav>
            
            <div class="border-t border-gray-200/60 p-6 mt-auto">
                <p class="text-sm font-semibold text-gray-900">
                    Your Role: {{ ucfirst($loggedInUser->role ?? 'Standard') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Team Status: <span class="font-medium text-blue-600">{{ $teamsJoined }} Joined</span>
                </p>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="glass-card border-b border-gray-200/60">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <h1 class="text-2xl font-bold bg-clip-text text-gray-900">Welcome Back, {{ $loggedInUser->name ?? 'User' }}!</h1>
                        
                        <div class="flex items-center gap-4">
                            @livewire('team-switcher')
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="h-10 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-xl transition-all duration-200 flex items-center gap-2 hover-lift">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-10">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="glass-card p-6 border-2 border-indigo-500/50 rounded-xl shadow-lg mb-8">
                         <div class="flex items-center justify-between">
                            <p class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-bullhorn text-indigo-600"></i> Active Submission Context:
                            </p>
                            <span class="text-lg font-extrabold text-purple-700">
                                {{ $activeTeam->name ?? 'NO TEAM SELECTED' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Ideas submitted will be tagged under the selected team. Please manage your teams if the list is empty.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="glass-card p-6 rounded-2xl border border-gray-200 hover-lift">
                            <p class="text-sm font-medium text-gray-600 mb-2">My Total Ideas</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $ideasSubmitted }}</p>
                        </div>
                         <div class="glass-card p-6 rounded-2xl border border-gray-200 hover-lift">
                            <p class="text-sm font-medium text-gray-600 mb-2">Ideas In Progress</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $ideasInProgress }}</p>
                        </div>
                         <div class="glass-card p-6 rounded-2xl border border-gray-200 hover-lift">
                            <p class="text-sm font-medium text-gray-600 mb-2">Teams Joined</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $teamsJoined }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        
                        <div class="glass-card p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Team Membership</h3>
                            <p class="text-gray-600 mb-4 text-sm">
                                Join or leave collaboration teams created by the project administrator.
                            </p>
                            @livewire('user-team-joiner')
                        </div>
                        
                        <div class="glass-card p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Submit Project Ideas</h3>
                            <p class="text-gray-600 mb-4 text-sm">
                                Access the pipeline to view or submit new ideas under your active team.
                            </p>
                            <a href="/pipeline" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition inline-flex items-center gap-2">
                                Go to Pipeline <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-6 space-y-3">
                        <p class="text-sm text-gray-500 text-center">
                            *This workspace is managed by {{ strtoupper(tenant('id')) }}. You are a Standard User with restricted access.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>

<script>
    // JS for sidebar toggle logic (Essential for mobile)
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
</div>