<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Account | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="antialiased bg-gray-100">
    
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-700">
                {{ strtoupper(tenant('id')) }} Workspace
            </h1>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl border border-gray-200">
                
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Welcome, {{ auth()->user()->name }}!
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    You have successfully logged in to your private workspace.
                </p>
                
                <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg shadow-inner mb-8">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-semibold text-indigo-700 flex items-center gap-2">
                            <i class="fas fa-bullhorn"></i> CURRENT CONTEXT:
                        </p>
                        
                        @livewire('team-switcher') 
                    </div>
                </div>

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
                        {{ auth()->user()->email }}
                    </p>
                    <p class="text-sm text-gray-500">
                        *Aapko Management Dashboard (Admin Panel) access karne ki ijazat nahi hai.
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>