@extends('components.layouts.tenant-app-layout', ['title' => 'Submit New Idea'])

@section('content')
<div class="max-w-4xl mx-auto py-8">
    
    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-400 text-red-700 animate-fade-in">
            <p class="font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
    @endif
    
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-xl bg-green-100 border border-green-400 text-green-700 animate-fade-in">
            <p class="font-medium">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
            </p>
        </div>
    @endif

    <form x-data="{ currentStep: @entangle('currentStep') }" wire:submit.prevent="submitIdea" class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
        
        <div class="mb-8">
            <div class="flex justify-between text-sm font-medium">
                <span class="text-xs uppercase {{ $currentStep >= 1 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 1: Problem</span>
                <span class="text-xs uppercase {{ $currentStep >= 2 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 2: Goal</span>
                <span class="text-xs uppercase {{ $currentStep >= 3 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 3: Details</span>
                <span class="text-xs uppercase {{ $currentStep >= 4 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">Step 4: Review</span>
            </div>
            <div class="mt-2 h-2 bg-gray-200 rounded-full">
                <div class="h-2 bg-indigo-600 rounded-full transition-all duration-500" style="width: {{ ($currentStep / $maxSteps) * 100 }}%"></div>
            </div>
        </div>

        <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg mb-8">
            <p class="text-sm font-semibold text-indigo-700 flex items-center gap-2">
                <i class="fas fa-users-cog"></i> Submitting to Team: 
                <span class="text-indigo-900 font-extrabold">{{ $activeTeam->name ?? 'NO TEAM SELECTED' }}</span>
            </p>
            @if(!$activeTeam)
                <p class="text-red-500 text-xs mt-1">Please select an active team in the dashboard to enable submission.</p>
            @endif
        </div>
        
        <div x-show="currentStep === 1">
            <h2 class="text-xl font-bold mb-4">Step 1: Your Problem</h2>
            <div class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Describe your problem in 4-5 words</label>
                    <input type="text" wire:model="problem_short" placeholder="e.g., Website login is difficult" class="w-full p-3 border rounded-lg">
                    @error('problem_short') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pain Score (1-10) - How badly does this hurt?</label>
                    <input type="number" wire:model="pain_score" min="1" max="10" placeholder="e.g. 8" class="w-24 p-3 border rounded-lg">
                    @error('pain_score') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div> --}}
            </div>
        </div>

        <div x-show="currentStep === 2" style="display: none;">
            <h2 class="text-xl font-bold mb-4">Step 2: Your Goal</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">What needs to change for you to be satisfied?</label>
                <textarea wire:model="goal" rows="3" placeholder="Describe the desired outcome." class="w-full p-3 border rounded-lg"></textarea>
                @error('goal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div x-show="currentStep === 3" style="display: none;">
            <h2 class="text-xl font-bold mb-4">Step 3: Problem Details</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Describe your problem or pain point in as much detail as possible here.</label>
                <textarea wire:model="problem_detail" rows="6" placeholder="Provide context, examples, and affected users." class="w-full p-3 border rounded-lg"></textarea>
                @error('problem_detail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div x-show="currentStep === 4" style="display: none;">
            <h2 class="text-xl font-bold mb-4">Step 4: Review & Submit</h2>
            <div class="space-y-4">
                <div class="p-4 border rounded-lg bg-gray-50">
                    <h3 class="font-semibold text-lg mb-2">Summary Review</h3>
                    <p class="text-sm text-gray-700">Problem: <strong>{{ $problem_short }}</strong></p>
                    <p class="text-sm text-gray-700">Goal: {{ $goal }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Email (for follow-up)</label>
                    <input type="email" wire:model="contact_info" placeholder="Your contact email" class="w-full p-3 border rounded-lg">
                    @error('contact_info') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-between">
            <button type="button" wire:click="previousStep" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg transition" 
                    x-show="currentStep > 1">
                &larr; Back
            </button>
            
            @if($currentStep < $maxSteps)
                <button type="button" wire:click="nextStep" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition ml-auto">
                    Next Step &rarr;
                </button>
            @else
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition ml-auto"
                        {{ !$activeTeam ? 'disabled' : '' }}>
                    <span wire:loading.remove>Submit Idea</span>
                    <span wire:loading>Submitting...</span>
                </button>
            @endif
        </div>
    </form>
</div>
@endsection