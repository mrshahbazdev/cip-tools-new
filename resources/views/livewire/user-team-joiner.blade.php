<div class="inline-block">

    <button wire:click="openJoinModal" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 transition duration-150 flex items-center gap-2">
        <i class="fas fa-users-cog"></i> 
        Manage My Teams
    </button>

    @if($isJoiningModalOpen)
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
                <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-3">Join & Switch Teams</h3>
                
                <form wire:submit.prevent="saveMembership" class="space-y-6">
                    
                    <p class="text-sm text-gray-600">Select the teams you wish to join for project collaboration. You can join multiple teams.</p>
                    
                    <div class="max-h-60 overflow-y-auto border border-gray-300 p-4 rounded-lg space-y-3 bg-gray-50">
                        @forelse($availableTeams as $team)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="joinedTeamIds" 
                                       value="{{ $team->id }}" 
                                       id="team-{{ $team->id }}"
                                       class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <label for="team-{{ $team->id }}" class="ml-3 text-sm text-gray-700 font-medium">
                                    {{ $team->name }} 
                                </label>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No teams have been created yet by the administrator.</p>
                        @endforelse
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" wire:click="$set('isJoiningModalOpen', false)" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-md hover:bg-purple-700 transition">
                            Save Membership
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>