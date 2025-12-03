<div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
    
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Innovation Pipeline</h1>
    <p class="text-gray-600 mb-8">Manage all submitted ideas, track status, and set priority.</p>

    <div class="bg-white p-6 rounded-xl shadow-lg mb-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by idea name or description..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            
            <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            
            <button wire:click="$set('search', ''); $set('statusFilter', '');" 
                    class="w-full px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                Reset Filters
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @include('livewire.partials.pipeline-table-header', ['field' => 'name', 'label' => 'Idea / Status'])
                        @include('livewire.partials.pipeline-table-header', ['field' => 'pain_score', 'label' => 'Pain Score'])
                        @include('livewire.partials.pipeline-table-header', ['field' => 'cost', 'label' => 'Cost (Kosten)'])
                        @include('livewire.partials.pipeline-table-header', ['field' => 'time_duration_hours', 'label' => 'Time (Dauer)'])
                        @include('livewire.partials.pipeline-table-header', ['field' => 'priority', 'label' => 'Priority (Umsetzung)'])
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ideas as $idea)
                        @include('livewire.partials.pipeline-table-row', ['idea' => $idea])
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-gray-500">No ideas found matching your criteria.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lg:hidden p-4 space-y-4">
            @forelse($ideas as $idea)
                @include('livewire.partials.pipeline-card-view', ['idea' => $idea])
            @empty
                <p class="p-4 text-center text-gray-500">No ideas found.</p>
            @endforelse
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $ideas->links() }}
        </div>
    </div>

</div>

{{-- Note: You must create the partial files below! --}}