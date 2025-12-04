<tr wire:key="idea-{{ $idea->id }}" 
    x-data="{ 
        isHovered: false,
        getStatusColor(status) {
            const colors = {
                'New': { bg: 'bg-blue-50', text: 'text-blue-700', border: 'border-blue-200' },
                'Reviewed': { bg: 'bg-cyan-50', text: 'text-cyan-700', border: 'border-cyan-200' },
                'Pending Pricing': { bg: 'bg-yellow-50', text: 'text-yellow-700', border: 'border-yellow-200' },
                'Approved Budget': { bg: 'bg-green-50', text: 'text-green-700', border: 'border-green-200' },
                'Implementation': { bg: 'bg-indigo-50', text: 'text-indigo-700', border: 'border-indigo-200' },
                'Done': { bg: 'bg-gray-100', text: 'text-gray-700', border: 'border-gray-300' }
            };
            return colors[status] || { bg: 'bg-gray-100', text: 'text-gray-700', border: 'border-gray-300' };
        },
        getPriorityColor(priority) {
            if (!priority) return 'bg-gradient-to-r from-gray-300 to-gray-400';
            if (priority >= 8) return 'bg-gradient-to-r from-red-500 to-pink-600';
            if (priority >= 6) return 'bg-gradient-to-r from-orange-500 to-red-500';
            if (priority >= 4) return 'bg-gradient-to-r from-yellow-500 to-orange-500';
            return 'bg-gradient-to-r from-green-500 to-emerald-600';
        }
    }"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50/50 hover:to-white transition-all duration-300"
>
    
    @php
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
        
        // Status color mapping
        $statusColors = [
            'New' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
            'Reviewed' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'Pending Pricing' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            'Approved Budget' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            'Implementation' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            'Done' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'M5 13l4 4L19 7'],
        ];
        $statusConfig = $statusColors[$idea->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'];
        
        // Priority indicator
        $priorityIndicator = match(true) {
            $idea->priority >= 8 => 'h-2 w-2 rounded-full bg-red-500',
            $idea->priority >= 6 => 'h-2 w-2 rounded-full bg-orange-500',
            $idea->priority >= 4 => 'h-2 w-2 rounded-full bg-yellow-500',
            $idea->priority >= 1 => 'h-2 w-2 rounded-full bg-green-500',
            default => 'h-2 w-2 rounded-full bg-gray-400',
        };
    @endphp

    <!-- IDEA / PROBLEM -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <!-- Priority Indicator -->
            <div class="{{ $priorityIndicator }}"></div>
            
            <div>
                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                    {{ $idea->problem_short }}
                </div>
                @if($idea->description)
                    <div class="text-xs text-gray-500 truncate max-w-xs">
                        {{ Str::limit($idea->description, 60) }}
                    </div>
                @endif
            </div>
        </div>
    </td>

    <!-- STATUS -->
    <td class="px-6 py-4">
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['bg'] === 'bg-gray-100' ? 'border-gray-300' : 'border-transparent' }}">
            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"/>
            </svg>
            {{ $idea->status }}
        </span>
    </td>

    <!-- PAIN SCORE -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <div class="relative">
                <div class="text-sm font-semibold text-yellow-900">
                    {{ $idea->pain_score ?? 'N/A' }}
                </div>
                @if($idea->pain_score)
                    <div class="absolute -bottom-1 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-yellow-200 rounded-full opacity-50"></div>
                @endif
            </div>
            <span class="text-xs text-yellow-600">/10</span>
        </div>
    </td>

    <!-- LÖSUNG (Developer Notes) -->
    <td class="px-6 py-4">
        <div class="max-w-xs">
            @if($idea->developer_notes)
                <div class="group relative">
                    <div class="text-sm text-gray-700 line-clamp-1">
                        {{ $idea->developer_notes }}
                    </div>
                    <!-- Tooltip on hover -->
                    <div class="absolute left-0 top-full mt-1 w-64 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                        <div class="font-medium mb-1">Developer Notes:</div>
                        <div class="text-gray-300">{{ $idea->developer_notes }}</div>
                    </div>
                </div>
            @else
                <span class="text-sm text-gray-400 italic">No notes</span>
            @endif
        </div>
    </td>

    <!-- COST -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-1">
            <span class="text-sm font-semibold text-gray-900">
                ${{ number_format($idea->cost, 2) }}
            </span>
            @if($idea->cost > 0)
                <span class="text-xs text-gray-500">
                    @if($idea->cost >= 10000)
                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    @elseif($idea->cost >= 1000)
                        <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </span>
            @endif
        </div>
    </td>

    <!-- DURATION -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <div class="text-sm font-semibold text-gray-900">
                {{ $idea->time_duration_hours ?? 'N/A' }}
            </div>
            @if($idea->time_duration_hours)
                <span class="text-xs text-gray-500">hours</span>
                <div class="h-2 w-8 bg-gradient-to-r from-blue-400 to-blue-300 rounded-full opacity-70"></div>
            @endif
        </div>
    </td>

    <!-- PRIO 1 -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <div class="text-sm font-semibold text-amber-900">
                {{ $idea->prio_1 ?? 'N/A' }}
            </div>
            @if($idea->prio_1)
                <div class="h-2 w-6 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full"></div>
            @endif
        </div>
    </td>

    <!-- PRIO 2 -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <div class="text-sm font-semibold text-orange-900">
                {{ $idea->prio_2 ?? 'N/A' }}
            </div>
            @if($idea->prio_2)
                <div class="h-2 w-6 bg-gradient-to-r from-orange-400 to-orange-300 rounded-full"></div>
            @endif
        </div>
    </td>

    <!-- PRIORITY -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="text-lg font-bold text-gray-900">
                    {{ $idea->priority ?? 'N/A' }}
                </div>
                @if($idea->priority)
                    <div 
                        :class="getPriorityColor({{ $idea->priority }})"
                        class="absolute -bottom-1 left-0 right-0 h-1.5 rounded-full opacity-70"
                    ></div>
                @endif
            </div>
            <span class="text-xs text-gray-500">/10</span>
        </div>
    </td>

    <!-- ACTIONS -->
    <td class="px-6 py-4">
        <div class="flex items-center space-x-3 justify-end" x-show="isHovered" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4">
            <!-- Edit Button -->
            <button 
                onclick="Livewire.dispatch('editIdea', { ideaId: {{ $idea->id }} })" 
                class="p-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center group"
                title="Edit Idea"
            >
                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>
            
            <!-- View Details Button -->
            <a href="/pipeline/{{ $idea->id }}">
                <button 
                    class="p-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-lg hover:from-gray-200 hover:to-gray-300 border border-gray-300 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center group"
                    title="View Details"
                >
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </a>
        </div>
        
        <!-- Static buttons (when not hovered) -->
        <div class="flex items-center space-x-3 justify-end" x-show="!isHovered" x-transition>
            <button 
                onclick="Livewire.dispatch('editIdea', { ideaId: {{ $idea->id }} })" 
                class="text-sm text-indigo-600 hover:text-indigo-900 font-medium flex items-center opacity-70 hover:opacity-100 transition-opacity"
            >
                Edit
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </td>
</tr>

@push('styles')
<style>
    /* Custom line clamp for text truncation */
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
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    /* Gradient border for selected rows */
    .selected-row {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
        border-left: 3px solid #6366f1;
    }
    
    /* Custom tooltip */
    [x-data] .tooltip {
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Alpine.js if not already initialized
    if (typeof Alpine === 'undefined') {
        document.addEventListener('alpine:init', () => {
            // Alpine is ready
        });
    }
    
    // Keyboard shortcuts for better UX
    document.addEventListener('keydown', function(e) {
        // 'e' to edit focused row (if we implement row focus)
        if (e.key === 'e' && e.altKey) {
            const focusedRow = document.querySelector('tr:focus-within');
            if (focusedRow) {
                const editBtn = focusedRow.querySelector('button[onclick*="editIdea"]');
                if (editBtn) editBtn.click();
            }
        }
    });
</script>
@endpush