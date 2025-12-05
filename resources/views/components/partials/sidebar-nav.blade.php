<aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200 z-40">
    
    @php
        $loggedInUser = auth()->user(); 
    @endphp

    <div class="p-6 border-b border-gray-200/60">
        <h2 class="text-xl font-extrabold text-gray-800">{{ strtoupper(tenant('id')) }}</h2>
        <p class="text-sm text-gray-500 mt-1">Innovation Hub</p>
    </div>
    
    <nav class="flex-1 p-6">
        <div class="mb-6">
            <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3 tracking-wider pl-2">Main Navigation</h3>
            
            <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-xl bg-indigo-50 text-indigo-700 mb-2 font-medium">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('tenant.pipeline') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-search"></i>
                <span>Innovation Pipeline</span>
            </a>
            
            <a href="{{ route('tenant.submit_idea') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-paper-plane"></i>
                <span>Submit Idea</span>
            </a>
            
            <a href="{{ route('tenant.my_ideas') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-lightbulb"></i>
                <span>My Ideas ({{ $ideasSubmitted ?? 0 }})</span>
            </a>>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3 tracking-wider pl-2">Administration</h3>
            
            <a href="{{ route('tenant.teams.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-users-cog"></i>
                <span>Manage Teams & Roles</span>
            </a>

            <a href="{{ route('tenant.users.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-users"></i>
                <span>Manage Members</span>
            </a>
            
            <a href="{{ route('tenant.settings') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-cog"></i>
                <span>Project Settings</span>
            </a>
            
            <a href="{{ route('tenant.billing') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                <i class="fas fa-credit-card"></i>
                <span>Billing & Plan</span>
            </a>
        </div>
    </nav>
    
    <div class="mt-auto p-4 border-t border-gray-200/60">
        <div class="p-4 bg-blue-50 rounded-lg">
            <p class="text-sm font-medium text-blue-800">Admin: {{ $loggedInUser->name ?? 'Project Admin' }}</p>
            <p class="text-xs text-blue-600 mt-1">{{ $loggedInUser->email }}</p>
        </div>
    </div>
</aside>