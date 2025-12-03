<div wire:key="mobile-idea-{{ $idea->id }}" class="bg-white p-4 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-200">
    @php
        $user = auth()->user();
        $isTenantAdmin = $user->isTenantAdmin();
        $isDeveloper = $user->isDeveloper();
        $isWorkBee = $user->isWorkBee();
        $isEditable = $isTenantAdmin || $isDeveloper || $isWorkBee;
    @endphp

    <div class="flex justify-between items-start mb-2">
        <div class="font-bold text-lg text-gray-900 leading-tight">
            {{ $idea->name }}
        </div>
        <a href="/pipeline/{{ $idea->id }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Details &rarr;</a>
    </div>

    <div class="text-sm font-medium mb-3">
        Status: 
        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">{{ $idea->status }}</span>
    </div>

    <div class="space-y-3 border-t border-gray-100 pt-3">
        
        <div class="flex justify-between">
            <span class="text-gray-600">Pain Score:</span>
            <span class="text-yellow-700 font-semibold">
                @if($isTenantAdmin || $isWorkBee)
                    <input type="number" min="1" max="10" wire:model="idea.pain_score"
                           wire:blur="saveIdeaField({{ $idea->id }}, 'pain_score', $event.target.value)"
                           class="w-16 border rounded text-center bg-yellow-50 border-yellow-300 text-sm">
                @else
                    {{ $idea->pain_score ?? 'N/A' }}
                @endif
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Cost (Kosten):</span>
            <span class="text-red-700 font-semibold">
                @if($isTenantAdmin || $isDeveloper)
                    <input type="number" step="0.01" wire:model="idea.cost"
                           wire:blur="saveIdeaField({{ $idea->id }}, 'cost', $event.target.value)"
                           class="w-24 border rounded text-right bg-red-50 border-red-300 text-sm">
                @else
                    ${{ number_format($idea->cost, 2) ?? 'N/A' }}
                @endif
            </span>
        </div>
        
        <div class="flex justify-between">
            <span class="text-gray-600">Priority:</span>
            <span class="text-green-700 font-semibold">
                @if($isTenantAdmin || $isWorkBee)
                    <input type="number" min="1" max="10" wire:model="idea.priority"
                           wire:blur="saveIdeaField({{ $idea->id }}, 'priority', $event.target.value)"
                           class="w-16 border rounded text-center bg-green-50 border-green-300 text-sm">
                @else
                    {{ $idea->priority ?? 'N/A' }}
                @endif
            </span>
        </div>

        <p class="text-xs text-gray-400 pt-2">Updated: {{ $idea->updated_at->diffForHumans() }}</p>
    </div>
</div>