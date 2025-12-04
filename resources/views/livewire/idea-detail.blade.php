<div>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="/pipeline" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Back to Pipeline
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">Idea Details</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $idea->problem_short }}</h1>
                    <p class="mt-2 text-gray-600">{{ $idea->description }}</p>
                </div>
                
                <!-- Status Badge -->
                @php
                    $statusColors = [
                        'New' => 'bg-blue-100 text-blue-800',
                        'Reviewed' => 'bg-cyan-100 text-cyan-800',
                        'Pending Pricing' => 'bg-yellow-100 text-yellow-800',
                        'Approved Budget' => 'bg-green-100 text-green-800',
                        'Implementation' => 'bg-indigo-100 text-indigo-800',
                        'Done' => 'bg-gray-100 text-gray-800',
                    ];
                    $statusColor = $statusColors[$idea->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                    {{ $idea->status }}
                </span>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Idea Details -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Description Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Description & Goal
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed mb-6">{{ $idea->description }}</p>
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="text-sm font-semibold text-indigo-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m0 0l3 3m-3-3l3-3M4 7V5a2 2 0 012-2h3.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2"/>
                                </svg>
                                Goal
                            </h4>
                            <p class="text-gray-800">{{ $ideaGoal ?? 'No specific goal defined' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Team Discussion
                                <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                                    {{ $idea->comments->count() }} {{ Str::plural('comment', $idea->comments->count()) }}
                                </span>
                            </div>
                        </h2>
                    </div>
                    
                    <!-- Comments List -->
                    <div class="p-6">
                        <div class="space-y-6 max-h-[500px] overflow-y-auto pr-4" id="comments-container">
                            @forelse($idea->comments->sortByDesc('created_at') as $comment)
                                <div class="flex space-x-4 group">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-semibold">
                                                {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="bg-gray-50 rounded-2xl p-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="font-semibold text-gray-900">{{ $comment->user->name ?? 'Unknown User' }}</span>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No comments yet</h3>
                                    <p class="mt-2 text-gray-500">Be the first to share your thoughts about this idea.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add Comment Form -->
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <form wire:submit.prevent="postComment" class="space-y-4">
                                <div>
                                    <label for="newComment" class="block text-sm font-medium text-gray-700 mb-2">
                                        Add your comment
                                    </label>
                                    <textarea 
                                        wire:model.defer="newComment" 
                                        id="newComment"
                                        rows="3" 
                                        placeholder="Share your thoughts, suggestions, or feedback..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none transition-colors duration-200 @error('newComment') border-red-500 @enderror"
                                    ></textarea>
                                    @error('newComment') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <button 
                                        type="submit" 
                                        class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 flex items-center"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Post Comment
                                    </button>
                                    
                                    <span class="text-sm text-gray-500">
                                        Press Ctrl+Enter to submit
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Stats & Info -->
            <div class="space-y-8">
                
                <!-- Stats Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Idea Metrics
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Pain Score -->
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                                <div class="flex items-center">
                                    <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Pain Score</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $idea->pain_score ?? 'N/A' }}/10</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost -->
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                                <div class="flex items-center">
                                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Estimated Cost</p>
                                        <p class="text-2xl font-bold text-gray-900">${{ number_format($idea->cost, 2) ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Duration</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $idea->time_duration_hours ?? 'N/A' }} hours</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Priority -->
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Priority Score</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $idea->priority ?? 'N/A' }}/10</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Meta Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m0 0l3 3m-3-3l3-3M4 7V5a2 2 0 012-2h3.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2"/>
                            </svg>
                            Additional Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <span class="text-sm text-gray-600">Submitted By</span>
                                <span class="font-medium text-gray-900">{{ $submittedBy ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <span class="text-sm text-gray-600">Created</span>
                                <span class="font-medium text-gray-900">{{ $idea->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <span class="text-sm text-gray-600">Last Updated</span>
                                <span class="font-medium text-gray-900">{{ $idea->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <span class="text-sm text-gray-600">PRIO 1</span>
                                <span class="font-medium text-gray-900">{{ $idea->prio_1 ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <span class="text-sm text-gray-600">PRIO 2</span>
                                <span class="font-medium text-gray-900">{{ $idea->prio_2 ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <h3 class="text-lg font-semibold mb-4">Ready to take action?</h3>
                        <div class="space-y-3">
                            <a 
                                href="/pipeline" 
                                class="flex items-center justify-center w-full px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-all duration-200 group"
                            >
                                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Pipeline
                            </a>
                            <button 
                                wire:click="$refresh"
                                class="flex items-center justify-center w-full px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-all duration-200 group"
                            >
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom of comments when new comment is added
    document.addEventListener('livewire:load', function () {
        Livewire.on('commentPosted', () => {
            const commentsContainer = document.getElementById('comments-container');
            if (commentsContainer) {
                commentsContainer.scrollTop = commentsContainer.scrollHeight;
            }
        });

        // Ctrl+Enter to submit comment
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.id === 'newComment') {
                    Livewire.emit('postComment');
                }
            }
        });
    });
</script>
@endpush
</div>