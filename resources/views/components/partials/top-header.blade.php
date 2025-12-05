<header class="glass-card border-b border-gray-200">
    
    @php
        $loggedInUser = auth()->user();
    @endphp

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold bg-clip-text text-gray-900">
                    {{ $header_title ?? 'Application Dashboard' }}
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                
                @livewire('team-switcher')
                
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