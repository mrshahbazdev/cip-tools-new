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
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .glass-card { background: rgba(255, 255, 255, 0.85); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06); }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="antialiased bg-gray-100">
    
    @php
        $loggedInUser = auth()->user();
    @endphp

    <div class="min-h-screen">
        
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-700">
                    {{ strtoupper(tenant('id')) }} Workspace
                </h1>
                
                <div class="flex items-center space-x-4">
                    @livewire('team-switcher') 
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="py-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl border border-gray-200">
                    
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Welcome, {{ $loggedInUser->name ?? 'User' }}!
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        You have successfully logged in to your private workspace.
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
                        <p class="text-sm text-gray-500">
                            *Aapko Management Dashboard (Admin Panel) access karne ki ijazat nahi hai.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>