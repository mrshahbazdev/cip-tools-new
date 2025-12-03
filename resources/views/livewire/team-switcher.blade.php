<div class="relative" x-data="{ open: false }" @click.away="open = false">
    @if(Auth::check() && $teams->count() > 0)
        <button @click="open = ! open" type="button" class="flex items-center space-x-2 px-4 py-2 bg-white rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 transition duration-150 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <i class="fas fa-users w-4 h-4 text-indigo-600"></i>
            <span class="font-medium text-sm mobile-hidden">
                {{ $teams->firstWhere('id', $activeTeamId)->name ?? 'Select Team' }}
            </span>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div x-show="open" x-cloak 
             class="absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-200 rounded-md shadow-xl z-50">
            <div class="py-1">
                @foreach($teams as $team)
                    <a href="#" wire:click.prevent="switchTeam({{ $team->id }})" @click="open = false"
                       class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        @if ($team->id == $activeTeamId)
                            <i class="fas fa-check-circle text-green-500"></i>
                        @else
                            <i class="far fa-circle text-gray-400"></i>
                        @endif
                        <span>{{ $team->name }}</span>
                    </a>
                @endforeach
            </div>
            <div class="border-t border-gray-100 p-2 text-center">
                <p class="text-xs text-gray-500">Active in session.</p>
            </div>
        </div>
    @endif
</div>