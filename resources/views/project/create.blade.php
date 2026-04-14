@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-1 h-8 bg-gradient-to-b from-[#AC7E2C] to-[#8C651F] rounded-full"></div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        {{ __('Create New Project') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">Fill in the project details below to get started</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8 sm:p-8">
                @csrf

                <!-- Main Information Section -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Project Information
                    </h3>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Project Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                Project Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name"
                                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#AC7E2C]/30 focus:border-[#AC7E2C] transition duration-200"
                                    placeholder="Enter project name" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="address" id="address"
                                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#AC7E2C]/30 focus:border-[#AC7E2C] transition duration-200"
                                    placeholder="Enter full address" required>
                            </div>
                        </div>

                        <!-- Builder Name -->
                        <div class="space-y-2">
                            <label for="builder_name" class="block text-sm font-semibold text-gray-700">
                                Builder Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="builder_name" id="builder_name"
                                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#AC7E2C]/30 focus:border-[#AC7E2C] transition duration-200"
                                    placeholder="Enter builder name" required>
                            </div>
                        </div>

                        <!-- Builder Contact Number -->
                        <div class="space-y-2">
                            <label for="builder_number" class="block text-sm font-semibold text-gray-700">
                                Builder Contact Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input type="tel" name="builder_number" id="builder_number"
                                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#AC7E2C]/30 focus:border-[#AC7E2C] transition duration-200"
                                    placeholder="Enter contact number" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Section -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Assignment Details
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        @if(auth('employee')->check())
                            <input type="hidden" name="assigned_employee" value="{{ auth('employee')->id() }}">
                            <div class="flex items-center p-4 space-x-3 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border border-amber-200">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 bg-[#AC7E2C]/10 rounded-full">
                                        <svg class="w-5 h-5 text-[#AC7E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Assigned Employee</p>
                                    <p class="text-base font-semibold text-gray-900">{{ auth('employee')->user()->name }}</p>
                                </div>
                            </div>
                        @else
                            <div class="space-y-2">
                                <label for="assigned_employee" class="block text-sm font-semibold text-gray-700">
                                    Assign Employee <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <select name="assigned_employee" id="assigned_employee"
                                        class="w-full py-2.5 pl-10 pr-10 text-gray-700 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-[#AC7E2C]/30 focus:border-[#AC7E2C] transition duration-200 bg-white cursor-pointer"
                                        required>
                                        <option value="" disabled selected>Select an employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Documents Section -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Documents
                    </h3>
                    <div class="space-y-3">
                        <label for="documents" class="block text-sm font-semibold text-gray-700">
                            Upload Documents
                        </label>
                        <div class="relative">
                            <input type="file" name="documents[]" id="documents" multiple
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition duration-200 cursor-pointer">
                        </div>
                        <div class="flex items-start p-3 space-x-2 text-xs text-blue-700 bg-blue-50 rounded-lg border border-blue-100">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="flex-1">You can upload multiple Excel files (.xlsx, .xls) to extract units automatically.</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col-reverse gap-3 pt-6 border-t border-gray-200 sm:flex-row sm:justify-end">
                    <button type="button" onclick="window.history.back()"
                        class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition duration-200 rounded-lg shadow-md bg-[#AC7E2C] hover:bg-[#8C651F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#AC7E2C] active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection