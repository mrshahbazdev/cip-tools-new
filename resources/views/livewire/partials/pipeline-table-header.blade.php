<th wire-click="sortBy('{{ $field }}')" 
    class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider 
           hover:text-gray-900 transition-colors duration-200 
           {{ $sortBy === $field ? 'text-indigo-600' : 'text-gray-500' }}">
    
    <div class="flex items-center space-x-1">
        <span>{{ $label }}</span>
        
        <svg class="w-3 h-3 transition-transform duration-300 transform 
             @if ($sortBy === $field)
                 text-indigo-600
                 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}
             @else
                 text-gray-400 group-hover:text-gray-500
             @endif" 
             fill="currentColor" viewBox="0 0 20 20">
            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
        </svg>
    </div>
</th>