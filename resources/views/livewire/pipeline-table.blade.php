{{-- SINGLE ROOT ELEMENT --}}
<div>
    @extends('components.layouts.tenant-app-layout', ['title' => 'Innovation Pipeline'])

    @section('content')
        
        <div class="space-y-8">

            <div class="mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Innovation Pipeline
                    </h1>
                    <a href="{{ route('tenant.submit_idea') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2 group">
                        <i class="fas fa-paper-plane"></i> Submit New Idea
                    </a>
                </div>
                <p class="text-gray-600">Manage all submitted ideas, track status, and set priority.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.300ms="search" 
                            type="text" 
                            placeholder="Search by idea name or description..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        >
                    </div>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <select 
                            wire:model.live="statusFilter" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white cursor-pointer transition-all duration-200"
                        >
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button 
                        wire:click="resetFilters" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 font-semibold rounded-xl hover:from-gray-200 hover:to-gray-100 border border-gray-300 transition-all duration-200 flex items-center justify-center group"
                    >
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset Filters
                    </button>
                </div>
                
                <div class="mt-4 flex flex-wrap gap-2">
                    @if($search)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Search: "{{ $search }}"
                            <button wire:click="$set('search', '')" class="ml-1.5 hover:bg-indigo-200 rounded-full p-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </span>
                    @endif
                    @if($statusFilter)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Status: {{ $statusFilter }}
                            <button wire:click="$set('statusFilter', '')" class="ml-1.5 hover:bg-green-200 rounded-full p-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 mt-8">
                <div class="hidden lg:block overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                {{-- 1. IDEA / PROBLEM --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'problem_short', 'label' => 'IDEA / PROBLEM'])
                                
                                {{-- 2. Status --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'status', 'label' => 'Status'])

                                {{-- 3. Schmerz --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'pain_score', 'label' => 'Schmerz'])
                                
                                {{-- 4. LÖSUNG --}}
                                <th class="bg-red-50/50 px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">LÖSUNG</th>
                                
                                {{-- 5. Kosten --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'cost', 'label' => 'Kosten'])
                                
                                {{-- 6. Dauer --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'time_duration_hours', 'label' => 'Dauer'])
                                
                                {{-- 7. PRIO 1 --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'prio_1', 'label' => 'PRIO 1'])
                                
                                {{-- 8. PRIO 2 --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'prio_2', 'label' => 'PRIO 2'])
                                
                                {{-- 9. Umsetzung --}}
                                @include('livewire.partials.pipeline-table-header', ['field' => 'priority', 'label' => 'Umsetzung'])

                                {{-- Actions Column --}}
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ideas as $idea)
                                @include('livewire.partials.pipeline-table-row', ['idea' => $idea])
                            @empty
                                <tr><td colspan="10" class="p-8 text-center text-gray-500">No ideas found matching your criteria.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="lg:hidden p-4 space-y-4">
                    @forelse($ideas as $idea)
                        @include('livewire.partials.pipeline-card-view', ['idea' => $idea])
                    @empty
                        <div class="text-center py-12"><h3 class="text-lg font-medium text-gray-900">No ideas found</h3></div>
                    @endforelse
                </div>
                
                @if($ideas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                                Showing <span class="font-medium">{{ $ideas->firstItem() }}</span> to <span class="font-medium">{{ $ideas->lastItem() }}</span> of <span class="font-medium">{{ $ideas->total() }}</span> results
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $ideas->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Tip:</span> Hover over rows to see actions.
                </div>
                <div class="flex items-center space-x-3">
                    <button 
                        wire:click="$refresh"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL COMPONENT LOAD --}}
        @livewire('idea-edit-modal')
    @endsection
</div>