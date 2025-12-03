<th wire:click="sortBy('{{ $field }}')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    <div class="flex items-center space-x-1">
        <span>{{ $label }}</span>
        @if ($sortBy === $field)
            <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? 'transform rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
        @endif
    </div>
</th>