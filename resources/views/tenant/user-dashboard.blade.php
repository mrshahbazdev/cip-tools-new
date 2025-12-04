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
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
    </style>
</head>
<body class="antialiased min-h-screen">

    @php
        $loggedInUser = auth()->user();
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
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Main Pipeline</h3>
                    
                    <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-50 text-indigo-700 mb-2 font-medium">
                        <i class="fas fa-home"></i>
                        <span>My Home</span>
                    </a>
                    <a href="/pipeline" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-search"></i>
                        <span>Pipeline View</span>
                    </a>
                    <a href="/submit-idea" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit New Idea</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-lightbulb"></i>
                        <span>My Ideas</span>
                    </a>
                </div>
            </nav>
            
            <div class="mt-auto p-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">User: {{ $loggedInUser->name ?? 'User' }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $loggedInUser->email }}</p>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-md border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <h1 class="text-lg font-semibold text-gray-800">Welcome User</h1>
                        
                        <div class="flex items-center space-x-4">
                            @livewire('team-switcher') 

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

            <main class="flex-1 py-10">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl border border-gray-200">
                        
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">
                            Welcome, {{ $loggedInUser->name ?? 'User' }}!
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            You have successfully logged in to your private workspace. Access your features below.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-3">Team Membership</h3>
                                <p class="text-gray-600 mb-4 text-sm">
                                    Join or leave collaboration teams created by the project administrator.
                                </p>
                                @livewire('user-team-joiner')
                            </div>
                            
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-3">Submit Project Ideas</h3>
                                <p class="text-gray-600 mb-4 text-sm">
                                    Access the pipeline to view or submit new ideas under your active team.
                                </p>
                                <a href="/pipeline" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition inline-flex items-center gap-2">
                                    Go to Pipeline <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>


                        <div class="mt-8 border-t border-gray-200 pt-6 space-y-3">
                            <p class="text-sm text-gray-700 font-medium">
                                <span class="text-indigo-600 mr-2">Email:</span> 
                                {{ $loggedInUser->email }}
                            </p>
                        </div>
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
</script>
</body>
</html>