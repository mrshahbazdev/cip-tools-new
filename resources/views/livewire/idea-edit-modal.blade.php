<div>
@if($isModalOpen)
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-200 overflow-hidden">
            
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">
                    Edit Idea: {{ $problem_short ?? 'Loading...' }}
                </h3>
                <button wire:click="$set('isModalOpen', false)" 
                    class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form wire:submit.prevent="saveChanges" class="p-6 space-y-6">
                
                @php
                    $isLocked = !$isTenantAdmin && !$isDeveloper && !$isWorkBee;
                @endphp

                <div class="space-y-4 border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800">1. Core Idea Details (Work-Bee)</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Idea Title (4-5 words)</label>
                        <input type="text" wire:model.defer="problem_short" 
                               class="w-full p-3 border rounded-lg bg-yellow-50/50" 
                               placeholder="e.g., Website login is difficult"
                               {{ $isLocked || (!$isTenantAdmin && !$isWorkBee) ? 'disabled' : '' }}>
                        @error('problem_short') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Goal (What needs to change?)</label>
                        <textarea wire:model.defer="goal" rows="2" 
                                  class="w-full p-3 border rounded-lg bg-yellow-50/50" 
                                  placeholder="Describe the desired outcome."
                                  {{ $isLocked || (!$isTenantAdmin && !$isWorkBee) ? 'disabled' : '' }}></textarea>
                        @error('goal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select wire:model.defer="status" class="w-full p-3 border rounded-lg bg-yellow-50/50" {{ $isLocked || (!$isTenantAdmin && !$isWorkBee) ? 'disabled' : '' }}>
                                @foreach(['New', 'Reviewed', 'Pending Pricing', 'Approved Budget', 'Implementation', 'Done'] as $statusOption)
                                    <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pain Score (Schmerz)</label>
                            <input type="number" wire:model.defer="pain_score" min="1" max="10" 
                                   class="w-full p-3 border rounded-lg bg-yellow-50/50" 
                                   {{ $isLocked || (!$isTenantAdmin && !$isWorkBee) ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800">2. Technical & Pricing (Developer)</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lösung / Developer Notes</label>
                        <textarea wire:model.defer="developer_notes" rows="3" 
                                  class="w-full p-3 border rounded-lg bg-red-50/50" 
                                  placeholder="Technical solution and implementation plan."
                                  {{ $isLocked || (!$isTenantAdmin && !$isDeveloper) ? 'disabled' : '' }}></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cost (Kosten)</label>
                            <input type="number" step="0.01" wire:model.defer="cost" 
                                   class="w-full p-3 border rounded-lg bg-red-50/50" 
                                   {{ $isLocked || (!$isTenantAdmin && !$isDeveloper) ? 'disabled' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Time (Dauer Hrs)</label>
                            <input type="number" wire:model.defer="time_duration_hours" 
                                   class="w-full p-3 border rounded-lg bg-red-50/50" 
                                   {{ $isLocked || (!$isTenantAdmin && !$isDeveloper) ? 'disabled' : '' }}>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Umsetzung (Final Priority)</label>
                            <input type="number" wire:model.defer="priority" min="1" max="10" 
                                   class="w-full p-3 border rounded-lg bg-yellow-50/50" 
                                   {{ $isLocked || (!$isTenantAdmin && !$isWorkBee) ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
                
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" wire:click="$set('isModalOpen', false)" class="px-5 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    
                    @if($isTenantAdmin || $isDeveloper || $isWorkBee)
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition duration-300 shadow-md">
                            Save Changes
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endif
</div>