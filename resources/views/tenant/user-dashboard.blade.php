<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }
        
        .sidebar-toggle { display: none; }
        
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
        
        .user-avatar {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-10 w-96 h-96 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 opacity-20 floating"></div>
        <div class="absolute bottom-1/4 right-10 w-80 h-80 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 opacity-20 floating" style="animation-delay: 2s;"></div>
    </div>

    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle fixed top-6 left-6 z-50 p-3 bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300">
        <i class="fas fa-bars text-gray-700 text-lg"></i>
    </button>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex w-72 flex-col glass-card border-r border-gray-200/60 z-40">
            <!-- Logo/Brand -->
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
            
            <!-- Navigation -->
            <nav class="flex-1 p-6">
                <div class="mb-8">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-4 tracking-wider pl-2">Main Navigation</h3>
                    
                    <div class="space-y-2">
                        <a href="/dashboard" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 font-medium hover-lift">
                            <div class="h-8 w-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <i class="fas fa-home text-indigo-600"></i>
                            </div>
                            <span>Dashboard Home</span>
                        </a>
                        
                        <a href="/pipeline" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift">
                            <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-search text-blue-600"></i>
                            </div>
                            <span>Pipeline View</span>
                        </a>
                        
                        <a href="/submit-idea" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift pulse-animation">
                            <div class="h-8 w-8 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-paper-plane text-green-600"></i>
                            </div>
                            <span>Submit New Idea</span>
                            <span class="ml-auto h-2 w-2 rounded-full bg-green-500"></span>
                        </a>
                        
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-gray-100 font-medium hover-lift">
                            <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-lightbulb text-purple-600"></i>
                            </div>
                            <span>My Ideas</span>
                            <span class="ml-auto text-xs font-semibold bg-purple-100 text-purple-800 px-2 py-1 rounded-full">3</span>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200/60 mb-6">
                    <p class="text-xs font-semibold text-gray-500 mb-2">Your Activity</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-2xl font-bold text-gray-900">5</p>
                            <p class="text-xs text-gray-500">Ideas Submitted</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">2</p>
                            <p class="text-xs text-gray-500">In Progress</p>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- User Profile -->
            <div class="border-t border-gray-200/60 p-6">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full user-avatar flex items-center justify-center text-white font-semibold shadow-lg">
                        {{ substr($loggedInUser->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $loggedInUser->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $loggedInUser->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="glass-card border-b border-gray-200/60">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Welcome Back!
                            </h1>
                            <div class="hidden md:flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-full">
                                <i class="fas fa-rocket text-indigo-600 text-xs"></i>
                                <span class="text-sm font-medium text-indigo-700">{{ strtoupper(tenant('id')) }} Workspace</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <!-- Team Switcher -->
                            @livewire('team-switcher')
                            
                            <!-- Notifications -->
                            <button class="h-10 w-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all duration-200 relative hover-lift">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute top-2 right-2 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="h-10 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-xl transition-all duration-200 flex items-center gap-2 hover-lift">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="mobile-hidden">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 py-10">
                <div class="max-w-6xl mx-auto px-6 lg:px-8">
                    <!-- Hero Welcome -->
                    <div class="glass-card rounded-2xl p-8 md:p-12 mb-8 gradient-header text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="h-16 w-16 rounded-full user-avatar flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                                    {{ substr($loggedInUser->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold mb-2">
                                        Welcome, {{ $loggedInUser->name ?? 'Innovator' }}! 🚀
                                    </h2>
                                    <p class="text-indigo-100 text-lg opacity-90">
                                        Ready to innovate? Your ideas can shape the future of {{ strtoupper(tenant('id')) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                        <!-- Team Membership Card -->
                        <div class="glass-card rounded-2xl p-8 border border-gray-200/60 hover-lift">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Team Collaboration</h3>
                                    <p class="text-gray-600 mb-6">
                                        Join or manage your teams to collaborate on innovative projects with colleagues.
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    Active
                                </span>
                            </div>
                            
                            <!-- Team Joiner Component -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200/60 p-6">
                                @livewire('user-team-joiner')
                            </div>
                        </div>

                        <!-- Idea Submission Card -->
                        <div class="glass-card rounded-2xl p-8 border border-gray-200/60 hover-lift">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-lightbulb text-green-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Submit Ideas</h3>
                                    <p class="text-gray-600 mb-6">
                                        Share your innovative ideas through our streamlined pipeline submission process.
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    New
                                </span>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200/60">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                            <i class="fas fa-eye text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">View Pipeline</p>
                                            <p class="text-sm text-gray-500">Browse current ideas and projects</p>
                                        </div>
                                    </div>
                                    <a href="/pipeline" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 inline-flex items-center gap-2">
                                        View <i class="fas fa-arrow-right text-sm"></i>
                                    </a>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200/60">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-plus text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Submit New Idea</p>
                                            <p class="text-sm text-gray-500">Start a new innovation proposal</p>
                                        </div>
                                    </div>
                                    <a href="/submit-idea" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-indigo-600 transition-all duration-200 inline-flex items-center gap-2">
                                        Create <i class="fas fa-arrow-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Information & Stats -->
                    <div class="glass-card rounded-2xl p-8 border border-gray-200/60">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-user-circle text-indigo-600"></i>
                            Your Account Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Profile Info -->
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200/60">
                                    <p class="text-sm font-medium text-gray-500 mb-2">Account Information</p>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-700">Full Name</span>
                                            <span class="font-semibold text-gray-900">{{ $loggedInUser->name ?? 'User' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-700">Email Address</span>
                                            <span class="font-semibold text-gray-900">{{ $loggedInUser->email }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-700">Member Since</span>
                                            <span class="font-semibold text-gray-900">{{ $loggedInUser->created_at->format('M d, Y') ?? 'Recently' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200/60">
                                    <p class="text-sm font-medium text-gray-500 mb-4">Activity Summary</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center p-3 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg">
                                            <p class="text-2xl font-bold text-indigo-700">5</p>
                                            <p class="text-xs text-indigo-600">Ideas Submitted</p>
                                        </div>
                                        <div class="text-center p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-lg">
                                            <p class="text-2xl font-bold text-green-700">2</p>
                                            <p class="text-xs text-green-600">Under Review</p>
                                        </div>
                                        <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg">
                                            <p class="text-2xl font-bold text-blue-700">1</p>
                                            <p class="text-xs text-blue-600">Approved</p>
                                        </div>
                                        <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg">
                                            <p class="text-2xl font-bold text-purple-700">3</p>
                                            <p class="text-xs text-purple-600">Teams Joined</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200/60">
                                    <p class="text-sm font-medium text-gray-500 mb-4">Quick Actions</p>
                                    <div class="space-y-3">
                                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                            <div class="h-8 w-8 rounded-md bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-cog text-gray-600"></i>
                                            </div>
                                            <span class="font-medium text-gray-800">Account Settings</span>
                                        </a>
                                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                            <div class="h-8 w-8 rounded-md bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-question-circle text-gray-600"></i>
                                            </div>
                                            <span class="font-medium text-gray-800">Help & Support</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('flex');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-40');
            sidebar.classList.toggle('w-72');
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
        
        // Add hover effects to interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            const hoverElements = document.querySelectorAll('.hover-lift');
            hoverElements.forEach(el => {
                el.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                });
            });
            
            // Animate stats cards on load
            const statsCards = document.querySelectorAll('.glass-card');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>