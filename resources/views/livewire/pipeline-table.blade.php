<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Innovation Pipeline
                            @if($isDeveloper)
                                <span class="ml-3 px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Developer View</span>
                            @endif
                        </h1>
                        <p class="mt-2 text-gray-600">Manage all submitted ideas, track status, and set priority.</p>
                    </div>
                    
                    <!-- Stats Overview -->
                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:flex items-center space-x-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $ideas->total() }}</div>
                                <div class="text-sm text-gray-500">Total Ideas</div>
                            </div>
                            <div class="h-8 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-indigo-600">{{ $ideas->where('status', 'Implementation')->count() }}</div>
                                <div class="text-sm text-gray-500">In Progress</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">New Ideas</p>
                                <p class="text-xl font-bold text-gray-900">{{ $ideas->where('status', 'New')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pending Pricing</p>
                                <p class="text-xl font-bold text-gray-900">{{ $ideas->where('status', 'Pending Pricing')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Approved</p>
                                <p class="text-xl font-bold text-gray-900">{{ $ideas->where('status', 'Approved Budget')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Completed</p>
                                <p class="text-xl font-bold text-gray-900">{{ $ideas->where('status', 'Done')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
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
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                
                <!-- Active Filters Badges -->
                <div class="mt-4 flex flex-wrap gap-2">
                    @if($search)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Search: "{{ $search }}"
                            <button wire:click="$set('search', '')" class="ml-1.5 hover:bg-indigo-200 rounded-full p-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif
                    @if($statusFilter)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Status: {{ $statusFilter }}
                            <button wire:click="$set('statusFilter', '')" class="ml-1.5 hover:bg-green-200 rounded-full p-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <!-- Desktop View -->
                <div class="hidden lg:block overflow-x-auto custom-scrollbar">
                    <div class="min-w-[1200px]">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <!-- IDEA / PROBLEM -->
                                    <th class="px-4 py-3 text-left min-w-[200px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">IDEA / PROBLEM</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Status -->
                                    <th class="px-4 py-3 text-left min-w-[120px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Status</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Pain -->
                                    <th class="px-4 py-3 text-left min-w-[80px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Pain</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Lösung -->
                                    <th class="px-4 py-3 text-left min-w-[150px] bg-red-50/50">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">LÖSUNG</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Cost -->
                                    <th class="px-4 py-3 text-left min-w-[100px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Cost</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Duration -->
                                    <th class="px-4 py-3 text-left min-w-[100px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Duration</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Prio 1 -->
                                    <th class="px-4 py-3 text-left min-w-[80px] bg-amber-50">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">PRIO 1</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Prio 2 -->
                                    <th class="px-4 py-3 text-left min-w-[80px] bg-orange-50">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">PRIO 2</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Priority -->
                                    <th class="px-4 py-3 text-left min-w-[100px]">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Priority</span>
                                        </div>
                                    </th>
                                    
                                    <!-- Actions -->
                                    <th class="px-4 py-3 text-right min-w-[120px]">
                                        <div class="flex items-center justify-end space-x-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span class="text-xs font-semibold uppercase">Actions</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($ideas as $idea)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Problem -->
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900 text-sm">{{ $idea->problem_short }}</div>
                                            <div class="text-xs text-gray-500 mt-1 truncate">{{ Str::limit($idea->description, 50) }}</div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'New' => 'bg-blue-100 text-blue-800',
                                                    'Pending Pricing' => 'bg-yellow-100 text-yellow-800',
                                                    'Approved Budget' => 'bg-green-100 text-green-800',
                                                    'Implementation' => 'bg-purple-100 text-purple-800',
                                                    'Done' => 'bg-gray-100 text-gray-800',
                                                ];
                                                $statusColor = $statusColors[$idea->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $idea->status }}
                                            </span>
                                        </td>
                                        
                                        <!-- Pain Score -->
                                        <td class="px-4 py-3">
                                            <div class="text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-800 font-bold text-sm">
                                                    {{ $idea->pain_score ?? '0' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Lösung -->
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-900">{{ $idea->solution_short ?? 'N/A' }}</div>
                                        </td>
                                        
                                        <!-- Cost -->
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">
                                                @if($idea->cost)
                                                    €{{ number_format($idea->cost, 0) }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Duration -->
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">
                                                @if($idea->time_duration_hours)
                                                    {{ $idea->time_duration_hours }}h
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Prio 1 -->
                                        <td class="px-4 py-3">
                                            <div class="text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-bold text-sm">
                                                    {{ $idea->prio_1 ?? '0' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Prio 2 -->
                                        <td class="px-4 py-3">
                                            <div class="text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold text-sm">
                                                    {{ $idea->prio_2 ?? '0' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Priority -->
                                        <td class="px-4 py-3">
                                            <div class="text-center">
                                                @php
                                                    $priorityColors = [
                                                        'High' => 'bg-red-100 text-red-800',
                                                        'Medium' => 'bg-yellow-100 text-yellow-800',
                                                        'Low' => 'bg-green-100 text-green-800',
                                                    ];
                                                    $priorityColor = $priorityColors[$idea->priority] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}">
                                                    {{ $idea->priority ?? 'Medium' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button 
                                                    wire:click="edit({{ $idea->id }})"
                                                    class="p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                    title="Edit Idea"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                                
                                                @if($isDeveloper)
                                                    <button 
                                                        wire:click="delete({{ $idea->id }})"
                                                        onclick="return confirm('Are you sure you want to delete this idea?')"
                                                        class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Delete Idea"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-16 text-center">
                                            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No ideas found</h3>
                                            <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
                                            <button 
                                                wire:click="resetFilters" 
                                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200"
                                            >
                                                Reset Filters
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards View -->
                <div class="lg:hidden">
                    <div class="p-4 space-y-4">
                        @forelse($ideas as $idea)
                            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $idea->problem_short }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($idea->description, 80) }}</p>
                                    </div>
                                    
                                    @php
                                        $statusColors = [
                                            'New' => 'bg-blue-100 text-blue-800',
                                            'Pending Pricing' => 'bg-yellow-100 text-yellow-800',
                                            'Approved Budget' => 'bg-green-100 text-green-800',
                                            'Implementation' => 'bg-purple-100 text-purple-800',
                                            'Done' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusColor = $statusColors[$idea->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ $idea->status }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Pain</div>
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-800 font-bold text-sm">
                                            {{ $idea->pain_score ?? '0' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Cost</div>
                                        <div class="font-medium">
                                            @if($idea->cost)
                                                €{{ number_format($idea->cost, 0) }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Duration</div>
                                        <div class="font-medium">
                                            @if($idea->time_duration_hours)
                                                {{ $idea->time_duration_hours }}h
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Priority</div>
                                        @php
                                            $priorityColors = [
                                                'High' => 'bg-red-100 text-red-800',
                                                'Medium' => 'bg-yellow-100 text-yellow-800',
                                                'Low' => 'bg-green-100 text-green-800',
                                            ];
                                            $priorityColor = $priorityColors[$idea->priority] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}">
                                            {{ $idea->priority ?? 'Medium' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Lösung for Mobile -->
                                <div class="mb-3">
                                    <div class="text-xs text-gray-500 mb-1">Lösung</div>
                                    <div class="text-sm text-gray-900">{{ $idea->solution_short ?? 'N/A' }}</div>
                                </div>
                                
                                <!-- Prio Scores for Mobile -->
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Prio 1</div>
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-bold text-sm">
                                            {{ $idea->prio_1 ?? '0' }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Prio 2</div>
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold text-sm">
                                            {{ $idea->prio_2 ?? '0' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                    <div class="text-xs text-gray-500">
                                        {{ $idea->created_at->format('M d, Y') }}
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="edit({{ $idea->id }})"
                                            class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition-colors"
                                        >
                                            Edit
                                        </button>
                                        
                                        @if($isDeveloper)
                                            <button 
                                                wire:click="delete({{ $idea->id }})"
                                                onclick="return confirm('Delete this idea?')"
                                                class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors"
                                            >
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="mx-auto w-16 h-16 text-gray-400 mb-4">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No ideas found</h3>
                                <p class="text-gray-500">Try adjusting your search or filter.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($ideas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                                Showing 
                                <span class="font-medium">{{ $ideas->firstItem() }}</span>
                                to 
                                <span class="font-medium">{{ $ideas->lastItem() }}</span>
                                of 
                                <span class="font-medium">{{ $ideas->total() }}</span>
                                results
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $ideas->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bottom Action Bar -->
            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Tip:</span> Hover over rows to see actions. Click on status badges for quick edits.
                </div>
                <div class="flex items-center space-x-3">
                    <button 
                        wire:click="$refresh"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh
                    </button>
                    
                    @if($isDeveloper)
                        <a 
                            href="{{ route('ideas.export') }}" 
                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 flex items-center shadow-sm"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export Data
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal Component --}}
        @livewire('idea-edit-modal')
    </div>

    @push('styles')
    <style>
        /* Custom scrollbar for better UX */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Smooth table row transitions */
        tbody tr {
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0.02) 100%);
        }
        
        /* Ensure table cells have proper padding */
        table th, table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        
        /* Fixed column widths for better layout */
        .min-w-[1200px] table {
            table-layout: fixed;
            width: 100%;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1536px) {
            .min-w-[1200px] table {
                table-layout: auto;
            }
        }
        
        /* Better mobile card layout */
        @media (max-width: 1024px) {
            .bg-white.rounded-xl {
                border-radius: 0.75rem;
            }
            
            .shadow-sm:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            table {
                width: 100% !important;
                table-layout: auto !important;
            }
            
            th, td {
                padding: 0.5rem !important;
                font-size: 12px !important;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Smooth scroll to top on pagination click
        document.addEventListener('livewire:load', function () {
            Livewire.on('pageChanged', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            // Handle edit modal opening
            Livewire.on('openEditModal', (ideaId) => {
                // This will be handled by the idea-edit-modal component
                console.log('Opening edit modal for idea:', ideaId);
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+F to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }
            
            // Esc to clear filters
            if (e.key === 'Escape') {
                Livewire.emit('resetFilters');
            }
        });
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Handle mobile menu if exists
            const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenu.contains(event.target) && 
                    mobileMenuButton && !mobileMenuButton.contains(event.target) && 
                    !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</div>