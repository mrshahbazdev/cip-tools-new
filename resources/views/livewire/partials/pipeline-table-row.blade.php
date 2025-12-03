<tr wire:key="idea-{{ $idea->id }}" class="hover:bg-gray-50">
    
    @php
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
    @endphp

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">{{ $idea->name }}</div>
        
        @if($isTenantAdmin || $isWorkBee)
             <select 
                wire:model.live="idea.status" 
                wire:change="saveIdeaField({{ $idea->id }}, 'status', $event.target.value)"
                class="mt-1 px-2 py-1 border rounded text-xs bg-gray-100 border-gray-300 focus:ring-indigo-500">
                <option value="New">New</option>
                <option value="Reviewed">Reviewed</option>
                <option value="Pending Pricing">Pending Pricing</option>
                <option value="Approved Budget">Approved Budget</option>
                <option value="Done">Done</option>
            </select>
        @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 mt-1">{{ $idea->status }}</span>
        @endif
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" min="1" max="10" wire:model.live="idea.pain_score"
                   wire:blur="saveIdeaField({{ $idea->id }}, 'pain_score', $event.target.value)"
                   class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->pain_score ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">
        @if($isTenantAdmin || $isDeveloper)
            <input type="number" step="0.01" wire:model.live="idea.cost"
                   wire:blur="saveIdeaField({{ $idea->id }}, 'cost', $event.target.value)"
                   class="w-24 border rounded text-right bg-red-50 border-red-300">
        @else
            ${{ number_format($idea->cost, 2) ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">
        @if($isTenantAdmin || $isDeveloper)
            <input type="number" wire:model.live="idea.time_duration_hours"
                   wire:blur="saveIdeaField({{ $idea->id }}, 'time_duration_hours', $event.target.value)"
                   class="w-16 border rounded text-center bg-red-50 border-red-300">
            hrs
        @else
            {{ $idea->time_duration_hours ? $idea->time_duration_hours . ' hrs' : 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" min="1" max="10" wire:model.live="idea.priority"
                   wire:blur="saveIdeaField({{ $idea->id }}, 'priority', $event.target.value)"
                   class="w-16 border rounded text-center bg-green-50 border-green-300">
        @else
            {{ $idea->priority ?? 'N/A' }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" min="1" max="10" wire:model="idea.prio_1"
                wire:blur="saveIdeaField({{ $idea->id }}, 'prio_1', $event.target.value)"
                class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->prio_1 ?? 'N/A' }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" min="1" max="10" wire:model="idea.prio_2"
                wire:blur="saveIdeaField({{ $idea->id }}, 'prio_2', $event.target.value)"
                class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->prio_2 ?? 'N/A' }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <a href="/pipeline/{{ $idea->id }}" class="text-indigo-600 hover:text-indigo-900">View Details &rarr;</a>
    </td>
</tr>