@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="w-min-screen mx-auto mt-10">
        <header class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                Edit Project
            </h2>
        </header>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-xl shadow-md space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Project Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                    <input type="text" name="name" value="{{ $project->name }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Extracted Units (Read-only) -->
                <div>
                    <label for="ex_unit" class="block text-sm font-medium text-gray-700 mb-1">Extracted Units</label>
                    <input type="number" name="ex_unit" value="{{ $project->ex_unit }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100" readonly>
                    @if($project->units && count($project->units) > 0)
                        <p class="text-xs text-gray-500 mt-1">Units:
                            {{ implode(', ', array_slice($project->units, 0, 5)) }}{{ count($project->units) > 5 ? '...' : '' }}
                        </p>
                    @endif
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" value="{{ $project->address }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Builder Name -->
                <div>
                    <label for="builder_name" class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                    <input type="text" name="builder_name" value="{{ $project->builder_name }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Builder Number -->
                <div>
                    <label for="builder_number" class="block text-sm font-medium text-gray-700 mb-1">Builder Contact
                        Number</label>
                    <input type="text" name="builder_number" value="{{ $project->builder_number }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Assigned Employee -->
                <div>
                    @if(auth('employee')->check())
                        {{-- Agar employee login hai to hidden field --}}
                        <input type="hidden" name="assigned_employee" value="{{ auth('employee')->id() }}">
                        <p class="text-sm text-gray-600">
                            Assigned to: <strong>{{ auth('employee')->user()->name }}</strong>
                        </p>
                    @else
                        {{-- Agar admin login hai to dropdown dikhana --}}
                        <label for="assigned_employee" class="block text-sm font-medium text-gray-700 mb-1">Assign
                            Employee</label>
                        <select name="assigned_employee" id="assigned_employee"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="" disabled selected>Select an employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <!-- Current Documents -->
            @if($project->documents && count($project->documents) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Documents</label>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        @foreach($project->documents as $document)
                            <div class="text-sm text-gray-600">{{ basename($document) }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Upload New Documents -->
            <div>
                <label for="documents" class="block text-sm font-medium text-gray-700 mb-1">Upload New Documents
                    (optional)</label>
                <input type="file" name="documents[]" multiple
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Upload Excel files to extract additional units.</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Project
                </button>
            </div>
        </form>
    </section>
@endsection