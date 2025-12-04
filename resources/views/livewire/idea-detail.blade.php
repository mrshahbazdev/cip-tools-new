<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">Idea: {{ $idea->name ?? 'Loading...' }}</h1>
    
    @if (session()->has('message'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="bg-white shadow-lg p-6 rounded-xl mb-8">
        <h3 class="text-xl font-semibold mb-3 border-b pb-2">Description & Goal</h3>
        <p class="mb-4 text-gray-700">{{ $idea->description }}</p>
        <p class="text-gray-500">Goal: {{ $idea->goal }}</p>
        <p class="text-sm text-gray-500 mt-4">Status: <span class="font-bold">{{ $idea->status }}</span></p>
    </div>

    <div class="grid grid-cols-3 gap-4 bg-gray-50 p-6 rounded-xl mb-8">
        <div><span class="font-semibold">Cost:</span> ${{ number_format($idea->cost, 2) }}</div>
        <div><span class="font-semibold">Pain:</span> {{ $idea->pain_score }}</div>
        <div><span class="font-semibold">Submitted By:</span> {{ $idea->submitter->name ?? 'Admin' }}</div>
    </div>
    
    <div class="mt-8">
        <h3 class="text-2xl font-bold mb-4">Team Comments ({{ $idea->comments->count() }})</h3>
        
        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
            @forelse($idea->comments as $comment)
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-indigo-600">{{ $comment->user->name ?? 'Unknown' }}</p>
                    <p class="text-gray-700 mt-1">{{ $comment->body }}</p>
                    <span class="text-xs text-gray-500 block mt-2">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-gray-500 italic">No comments yet. Be the first to discuss this idea.</p>
            @endforelse
        </div>
        
        <form wire:submit.prevent="postComment" class="mt-8 pt-4 border-t border-gray-200 space-y-3">
            <textarea wire:model.defer="newComment" rows="3" placeholder="Add your comment..." class="w-full p-3 border border-gray-300 rounded-lg @error('newComment') border-red-500 @enderror"></textarea>
            @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                Post Comment
            </button>
        </form>
    </div>
</div>