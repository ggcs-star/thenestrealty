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
        <h3 class="text-2xl font-bold text-gray-900">Create New Loan Stage</h3>
        <p class="text-gray-500 text-sm mt-1">Add a new stage for loan processing</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('loan-stages.store') }}">
            @csrf

            <div class="max-w-2xl">
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Stage Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Application Review, Document Verification, Final Approval"
                           required>
                    
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <p class="mt-2 text-sm text-gray-500">
                        Choose a clear and descriptive name for this loan stage
                    </p>
                </div>

                <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Stage
                    </button>
                    
                    <a href="{{ route('loan-stages.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Help Card --}}
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">About Loan Stages</h4>
                <p class="mt-1 text-sm text-blue-700">
                    Loan stages help you track the progress of loan applications through your workflow. 
                    Common stages include: Application Received, Under Review, Approved, Rejected, and Disbursed.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection