@php
    $hideDashboard = true;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('loan-stages.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Loan Stages
        </a>
        <h3 class="text-2xl font-bold text-gray-900">Edit Loan Stage</h3>
        <p class="text-gray-500 text-sm mt-1">Update stage: <span class="font-medium text-gray-700">{{ $stage->name }}</span></p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('loan-stages.update', $stage->id) }}">
            @csrf
            @method('PUT')

            <div class="max-w-2xl">
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Stage Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name', $stage->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Application Review, Document Verification, Final Approval"
                           required>
                    
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stage Info --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Created:</span> {{ $stage->created_at->format('d M, Y') }}
                            </p>
                            @if($stage->created_at != $stage->updated_at)
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-medium">Last Updated:</span> {{ $stage->updated_at->format('d M, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Stage
                    </button>
                    
                    <a href="{{ route('loan-stages.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-red-800">Danger Zone</h4>
                    <p class="text-sm text-red-700">Deleting this stage will permanently remove it from the system.</p>
                </div>
            </div>
            <form action="{{ route('loan-stages.destroy', $stage->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Are you absolutely sure you want to delete this stage? This action cannot be undone.')" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Stage
                </button>
            </form>
        </div>
    </div>
</div>
@endsection