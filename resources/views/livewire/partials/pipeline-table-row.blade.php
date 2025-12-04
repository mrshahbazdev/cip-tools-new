<tr wire:key="idea-{{ $idea->id }}" class="hover:bg-gray-50">
    
    @php
        // Role identification for column locking
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
        
        // Helper to determine the status background color (for non-editable display)
        $statusBg = match ($idea->status) {
            'New' => 'bg-blue-50 text-blue-700',
            'Reviewed' => 'bg-cyan-50 text-cyan-700',
            'Pending Pricing' => 'bg-yellow-50 text-yellow-700',
            'Approved Budget' => 'bg-green-50 text-green-700',
            'Implementation' => 'bg-indigo-50 text-indigo-700',
            'Done' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };
    @endphp

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">{{ $idea->problem_short }}</div>
        
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBg }} mt-1">{{ $idea->status }}</span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        {{ $idea->pain_score ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        {{ $idea->developer_notes ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        ${{ number_format($idea->cost, 2) ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        {{ $idea->time_duration_hours ? $idea->time_duration_hours . ' hrs' : 'N/A' }}
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        {{ $idea->prio_1 ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        {{ $idea->prio_2 ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700 bg-yellow-50/50">
        {{ $idea->priority ?? 'N/A' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <button onclick="Livewire.dispatch('editIdea', { ideaId: {{ $idea->id }} })" 
        class="text-indigo-600 hover:text-indigo-900">Edit Details &rarr;</button>
        <a href="/pipeline/{{ $idea->id }}"><button  class="text-indigo-600 hover:text-indigo-900">View</button></a>
    </td>
</tr>