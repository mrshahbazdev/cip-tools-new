<tr wire:key="idea-{{ $idea->id }}" class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">{{ $idea->name }}</div>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 mt-1">{{ $idea->status }}</span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700">{{ $idea->pain_score ?? 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">${{ number_format($idea->cost, 2) ?? 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">{{ $idea->time_duration_hours ? $idea->time_duration_hours . ' hrs' : 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700">{{ $idea->priority ?? 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <a href="/pipeline/{{ $idea->id }}" class="text-indigo-600 hover:text-indigo-900">View Details &rarr;</a>
    </td>
</tr>