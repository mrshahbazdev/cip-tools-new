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
                Welcome, {{ auth()->user()->name }}!
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                You have successfully logged in to your private workspace.
            </p>
            
            <div class="hidden">@livewire('team-switcher')</div> 

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

            </div>
    </div>
</main>