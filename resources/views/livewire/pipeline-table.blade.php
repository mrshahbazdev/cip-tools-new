@extends('components.layouts.tenant-app-layout', ['title' => 'Innovation Pipeline'])

@section('content')

    <div class="space-y-8"> 
        
        <div class="mb-6">
            </div>

        <div class="bg-white p-6 rounded-xl shadow-lg mb-8 p-6">
            </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 mt-8">
            @if($ideas->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{-- Pagination Links Here --}}
                </div>
            @endif
        </div>

        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            </div>

        {{-- MODAL COMPONENT LOAD (Ye bhi isi root div ke andar hona chahiye) --}}
        @livewire('idea-edit-modal')
        
    </div>
    @endsection