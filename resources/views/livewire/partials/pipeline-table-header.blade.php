@php
    // Define icons for different columns
    $icons = [
        'problem_short' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
        'status' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'pain_score' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'cost' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'time_duration_hours' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'prio_1' => 'M13 10V3L4 14h7v7l9-11h-7z',
        'prio_2' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        'priority' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
    ];
    
    $icon = $icons[$field] ?? 'M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z';
    
    // Define background colors for different columns
    $bgColors = [
        'pain_score' => 'bg-gradient-to-r from-yellow-50 to-yellow-100/50',
        'prio_1' => 'bg-gradient-to-r from-amber-50 to-amber-100/50',
        'prio_2' => 'bg-gradient-to-r from-orange-50 to-orange-100/50',
        'priority' => 'bg-gradient-to-r from-green-50 to-green-100/50',
        'cost' => 'bg-gradient-to-r from-red-50 to-red-100/50',
        'time_duration_hours' => 'bg-gradient-to-r from-blue-50 to-blue-100/50',
    ];
    
    $bgColor = $bgColors[$field] ?? 'bg-gradient-to-r from-gray-50 to-gray-100/50';
    
    // Define text colors based on field type
    $textColors = [
        'pain_score' => 'text-yellow-700',
        'prio_1' => 'text-amber-700',
        'prio_2' => 'text-orange-700',
        'priority' => 'text-green-700',
        'cost' => 'text-red-700',
        'time_duration_hours' => 'text-blue-700',
    ];
    
    $textColor = $textColors[$field] ?? 'text-gray-700';
@endphp

<th 
    wire:click="sortBy('{{ $field }}')" 
    class="cursor-pointer px-6 py-4 text-left transition-all duration-300 group relative overflow-hidden {{ $bgColor }}"
    x-data="{ isHovered: false }"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
>
    <!-- Background animation on hover -->
    <div 
        class="absolute inset-0 bg-gradient-to-r from-indigo-500/0 via-indigo-500/5 to-indigo-500/0 transform -translate-x-full transition-transform duration-700 ease-out"
        :class="{ 'translate-x-full': isHovered }"
    ></div>
    
    <div class="relative flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <!-- Icon Container -->
            <div class="p-2 rounded-lg bg-white/80 backdrop-blur-sm shadow-sm border border-white/50">
                <svg class="w-4 h-4 {{ $textColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
                </svg>
            </div>
            
            <!-- Label with animated underline -->
            <div class="relative">
                <span class="text-xs font-semibold uppercase tracking-wider {{ $textColor }} group-hover:text-gray-900 transition-colors duration-200">
                    {{ $label }}
                </span>
                <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 group-hover:w-full transition-all duration-300"></div>
            </div>
        </div>
        
        <!-- Sort Indicator -->
        <div class="flex items-center space-x-1">
            @if($sortBy === $field)
                <div class="flex flex-col items-center">
                    <svg 
                        class="w-3 h-3 text-indigo-600 mb-0.5 transition-transform duration-300 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}" 
                        fill="currentColor" viewBox="0 0 20 20"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-[10px] font-medium text-indigo-600">
                        {{ $sortDirection === 'asc' ? 'ASC' : 'DESC' }}
                    </div>
                </div>
            @else
                <svg 
                    class="w-3 h-3 text-gray-400 group-hover:text-gray-600 opacity-0 group-hover:opacity-100 transition-all duration-300" 
                    fill="currentColor" viewBox="0 0 20 20"
                >
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>
    </div>
    
    <!-- Column description tooltip (on hover) -->
    <div 
        class="absolute left-0 right-0 top-full mt-1 bg-gray-900 text-white text-xs rounded-lg p-2 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 transform translate-y-1 group-hover:translate-y-0"
        x-cloak
    >
        <div class="flex items-center space-x-2 mb-1">
            <svg class="w-3 h-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m0 0l3 3m-3-3l3-3M4 7V5a2 2 0 012-2h3.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2"/>
            </svg>
            <span class="font-semibold">Click to sort</span>
        </div>
        <div class="text-gray-300">
            @switch($field)
                @case('problem_short')
                    Sort by idea/problem description
                    @break
                @case('status')
                    Sort by current status
                    @break
                @case('pain_score')
                    Sort by pain score (1-10)
                    @break
                @case('cost')
                    Sort by estimated cost
                    @break
                @case('time_duration_hours')
                    Sort by implementation duration
                    @break
                @case('priority')
                    Sort by priority score
                    @break
                @default
                    Click to sort this column
            @endswitch
        </div>
    </div>
</th>

@push('styles')
<style>
    /* Smooth transition for tooltip */
    [x-cloak] { display: none !important; }
    
    /* Custom scrollbar for better UX */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add Alpine.js for interactivity
    document.addEventListener('alpine:init', () => {
        Alpine.data('headerSort', () => ({
            init() {
                // Any initialization code if needed
            }
        }));
    });
</script>
@endpush