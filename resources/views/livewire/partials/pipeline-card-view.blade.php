<div wire:key="mobile-idea-{{ $idea->id }}" 
     class="bg-white rounded-2xl shadow-sm border border-gray-200/80 hover:shadow-lg hover:border-gray-300 transition-all duration-300 group overflow-hidden">
    
    @php
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
        
        // Status badge colors
        $statusColors = [
            'New' => 'bg-blue-100 text-blue-800 border-blue-200',
            'Reviewed' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
            'Pending Pricing' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Approved Budget' => 'bg-green-100 text-green-800 border-green-200',
            'Implementation' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'Done' => 'bg-gray-100 text-gray-800 border-gray-200',
        ];
        $statusColor = $statusColors[$idea->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
        
        // Priority indicator colors
        $priorityColor = match(true) {
            $idea->priority >= 8 => 'bg-gradient-to-r from-red-500 to-pink-600',
            $idea->priority >= 6 => 'bg-gradient-to-r from-orange-500 to-red-500',
            $idea->priority >= 4 => 'bg-gradient-to-r from-yellow-500 to-orange-500',
            $idea->priority >= 1 => 'bg-gradient-to-r from-green-500 to-emerald-600',
            default => 'bg-gradient-to-r from-gray-400 to-gray-500',
        };
    @endphp

    <!-- Header Section -->
    <div class="p-5 pb-4 border-b border-gray-100">
        <div class="flex justify-between items-start mb-3">
            <div class="flex-1">
                <!-- Status Badge -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColor }} flex items-center gap-1">
                        @switch($idea->status)
                            @case('New')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                @break
                            @case('Implementation')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                @break
                            @case('Done')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                @break
                        @endswitch
                        {{ $idea->status }}
                    </span>
                    
                    <!-- Priority Indicator -->
                    @if($idea->priority)
                        <div class="h-6 w-1 rounded-full {{ $priorityColor }}"></div>
                    @endif
                </div>
                
                <!-- Idea Title -->
                <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">
                    {{ $idea->problem_short }}
                </h3>
                
                <!-- Idea Description (Truncated) -->
                @if($idea->description)
                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                        {{ Str::limit($idea->description, 80) }}
                    </p>
                @endif
            </div>
            
            <!-- Quick Action Button -->
            <a href="/pipeline/{{ $idea->id }}" 
               class="ml-3 p-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="p-5 pt-4">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <!-- Pain Score -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-xl p-3 border border-yellow-200/50">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-yellow-800 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pain Score
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    @if($isTenantAdmin || $isWorkBee)
                        <input type="number" 
                               min="1" 
                               max="10" 
                               value="{{ $idea->pain_score }}"
                               wire:blur="saveIdeaField({{ $idea->id }}, 'pain_score', $event.target.value)"
                               class="w-full text-lg font-bold text-yellow-900 bg-transparent border-0 focus:ring-0 p-0"
                               placeholder="N/A">
                    @else
                        <span class="text-2xl font-bold text-yellow-900">{{ $idea->pain_score ?? 'N/A' }}</span>
                    @endif
                    <span class="text-xs text-yellow-700/70">/10</span>
                </div>
            </div>

            <!-- Cost -->
            <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-3 border border-red-200/50">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-red-800 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Cost
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    @if($isTenantAdmin || $isDeveloper)
                        <input type="number" 
                               step="0.01" 
                               value="{{ $idea->cost }}"
                               wire:blur="saveIdeaField({{ $idea->id }}, 'cost', $event.target.value)"
                               class="w-full text-lg font-bold text-red-900 bg-transparent border-0 focus:ring-0 p-0"
                               placeholder="0.00">
                    @else
                        <span class="text-2xl font-bold text-red-900">${{ number_format($idea->cost, 2) ?? 'N/A' }}</span>
                    @endif
                </div>
            </div>

            <!-- Duration -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-3 border border-blue-200/50">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-blue-800 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Duration
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    @if($isTenantAdmin || $isDeveloper)
                        <input type="number" 
                               value="{{ $idea->time_duration_hours }}"
                               wire:blur="saveIdeaField({{ $idea->id }}, 'time_duration_hours', $event.target.value)"
                               class="w-full text-lg font-bold text-blue-900 bg-transparent border-0 focus:ring-0 p-0"
                               placeholder="0">
                    @else
                        <span class="text-2xl font-bold text-blue-900">{{ $idea->time_duration_hours ?? 'N/A' }}</span>
                    @endif
                    <span class="text-xs text-blue-700/70">hours</span>
                </div>
            </div>

            <!-- Priority -->
            <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-3 border border-green-200/50">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-green-800 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Priority
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    @if($isTenantAdmin || $isWorkBee)
                        <input type="number" 
                               min="1" 
                               max="10" 
                               value="{{ $idea->priority }}"
                               wire:blur="saveIdeaField({{ $idea->id }}, 'priority', $event.target.value)"
                               class="w-full text-lg font-bold text-green-900 bg-transparent border-0 focus:ring-0 p-0"
                               placeholder="N/A">
                    @else
                        <span class="text-2xl font-bold text-green-900">{{ $idea->priority ?? 'N/A' }}</span>
                    @endif
                    <span class="text-xs text-green-700/70">/10</span>
                </div>
            </div>
        </div>

        <!-- Developer Notes (if exists) -->
        @if($idea->developer_notes)
            <div class="mb-4">
                <div class="text-xs font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Developer Notes
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-sm text-gray-700 line-clamp-2">
                        {{ $idea->developer_notes }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Footer with timestamp and action -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Updated {{ $idea->updated_at->diffForHumans() }}
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- Quick Edit Button (if authorized) -->
                @if($isTenantAdmin || $isDeveloper || $isWorkBee)
                    <button 
                        wire:click="$dispatch('openEditModal', { id: {{ $idea->id }} })"
                        class="text-xs px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center"
                    >
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                @endif
                
                <!-- View Details Button -->
                <a href="/pipeline/{{ $idea->id }}" 
                   class="text-xs px-3 py-1.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 flex items-center shadow-sm hover:shadow"
                >
                    View Details
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Mode Indicator (when input is focused) -->
    <div class="hidden group-focus-within:flex items-center justify-center p-2 bg-indigo-50 border-t border-indigo-100">
        <svg class="w-4 h-4 text-indigo-600 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
        <span class="text-xs text-indigo-700 font-medium">Editing mode • Press Enter to save</span>
    </div>
</div>

@push('styles')
<style>
    /* Custom focus styles for inputs */
    input:focus {
        outline: none;
        background: white !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    /* Line clamp for text truncation */
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
    
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    /* Custom shadow on hover */
    .hover\:shadow-lg {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-save on Enter key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
            // Trigger blur to save the field
            e.target.blur();
        }
    });
    
    // Focus management for better mobile experience
    document.addEventListener('focusin', function(e) {
        if (e.target.matches('input[type="number"]')) {
            e.target.select();
        }
    });
</script>
@endpush