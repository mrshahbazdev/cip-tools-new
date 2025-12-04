<tr wire:key="idea-{{ $idea->id }}" class="hover:bg-gray-50">
    
    @php
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
    @endphp

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">{{ $idea->problem_short }}</div>
        
        @if($isTenantAdmin || $isWorkBee)
             <select 
                wire:model.live.debounce.1000ms="statuses.{{ $idea->id }}"
                @click.stop 
                class="mt-1 px-2 py-1 border rounded text-xs bg-gray-100 border-gray-300 focus:ring-indigo-500">
                
                @foreach(['New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'] as $statusOption)
                    <option value="{{ $statusOption }}" @selected($statusOption === $idea->status)>{{ $statusOption }}</option>
                @endforeach
            </select>
        @else
            @php
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
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBg }} mt-1">{{ $idea->status }}</span>
        @endif
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" 
                   min="1" 
                   max="10" 
                   wire:model.live.debounce.1000ms="painScores.{{ $idea->id }}"
                   @click.stop 
                   class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->pain_score ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        @if($isTenantAdmin || $isDeveloper)
            <input type="text" 
                   wire:model.live.debounce.1000ms="developerNotes.{{ $idea->id }}"
                   @click.stop 
                   class="w-24 border rounded bg-red-50 border-red-300">
        @else
            {{ $idea->developer_notes ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        @if($isTenantAdmin || $isDeveloper)
            <input type="number" 
                   step="0.01" 
                   wire:model.live.debounce.1000ms="costs.{{ $idea->id }}"
                   @click.stop 
                   class="w-24 border rounded text-right bg-red-50 border-red-300">
        @else
            ${{ number_format($idea->cost, 2) ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700 bg-red-50/50">
        @if($isTenantAdmin || $isDeveloper)
            <input type="number" 
                   wire:model.live.debounce.1000ms="timeDurations.{{ $idea->id }}"
                   @click.stop 
                   class="w-16 border rounded text-center bg-red-50 border-red-300">
            hrs
        @else
            {{ $idea->time_duration_hours ? $idea->time_duration_hours . ' hrs' : 'N/A' }}
        @endif
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" 
                   min="1" 
                   max="10" 
                   wire:model.live.debounce.1000ms="prio1.{{ $idea->id }}"
                   @click.stop 
                   class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->prio_1 ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 bg-yellow-50/50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" 
                   min="1" 
                   max="10" 
                   wire:model.live.debounce.1000ms="prio2.{{ $idea->id }}"
                   @click.stop 
                   class="w-16 border rounded text-center bg-yellow-50 border-yellow-300">
        @else
            {{ $idea->prio_2 ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700 bg-yellow-50/50">
        @if($isTenantAdmin || $isWorkBee)
            <input type="number" 
                   min="1" 
                   max="10" 
                   wire:model.live.debounce.1000ms="priorities.{{ $idea->id }}"
                   @click.stop 
                   class="w-16 border rounded text-center bg-green-50 border-green-300">
        @else
            {{ $idea->priority ?? 'N/A' }}
        @endif
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <a href="/pipeline/{{ $idea->id }}" class="text-indigo-600 hover:text-indigo-900">View Details →</a>
    </td>
</tr>