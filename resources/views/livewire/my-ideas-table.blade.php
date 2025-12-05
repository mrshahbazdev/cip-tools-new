<div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
    
    <h1 class="text-3xl font-bold text-gray-900 mb-6">My Submitted Ideas</h1>
    <p class="text-gray-600 mb-8">This view only shows ideas submitted by your account.</p>

    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded-xl bg-green-100 border border-green-400 text-green-700">
            {{ session('message') }}
        </div>
    @endif
    
    @include('livewire.pipeline-table', [
        'ideas' => $ideas, // Pass the filtered collection
        'statuses' => $statuses, // Pass statuses for filter dropdown
        'isMyIdeasView' => true // Flag used for UI differentiation
    ])
    
</div>