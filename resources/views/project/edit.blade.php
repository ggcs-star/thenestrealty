@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="px-6 py-6 w-full">

        <!-- HEADER -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Edit Project</h2>
            <p class="text-sm text-gray-500">Update project details</p>
        </div>

        <!-- CARD -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

            <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Project Name -->
                    <div>
                        <label class="text-sm text-gray-600">Project Name</label>
                        <input type="text" name="name" value="{{ $project->name }}"
                            class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                    </div>

                    <!-- Extracted Units -->
                    <div>
                        <label class="text-sm text-gray-600">Extracted Units</label>
                        <input type="number" value="{{ $project->ex_unit }}"
                            class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-100" readonly>

                        @if($project->units && count($project->units) > 0)
                            <p class="text-xs text-gray-400 mt-1">
                                {{ implode(', ', array_slice($project->units, 0, 5)) }}
                                {{ count($project->units) > 5 ? '...' : '' }}
                            </p>
                        @endif
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="text-sm text-gray-600">Address</label>
                        <input type="text" name="address" value="{{ $project->address }}"
                            class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                    </div>

                    <!-- Builder -->
                    <div>
                        <label class="text-sm text-gray-600">Builder Name</label>
                        <input type="text" name="builder_name" value="{{ $project->builder_name }}"
                            class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">
                    </div>

                    <!-- Contact -->
                    <div>
                        <label class="text-sm text-gray-600">Contact Number</label>
                        <input type="text" name="builder_number" value="{{ $project->builder_number }}"
                            class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">
                    </div>

                    <div>

                        @if(auth('employee')->check())

                            @php $user = auth('employee')->user(); @endphp

                            @if($user->isManager())

                                <label class="text-sm text-gray-600">Assign Employee</label>

                                <select name="assigned_employee" class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">

                                    <option disabled>Select employee</option>

                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ $project->assigned_employee == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }}
                                        </option>
                                    @endforeach

                                </select>

                            @else

                                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 text-sm text-gray-700">
                                    Assigned to: <strong>{{ $user->name }}</strong>
                                </div>

                                <input type="hidden" name="assigned_employee" value="{{ $user->id }}">

                            @endif

                        @else

                            <label class="text-sm text-gray-600">Assign Employee</label>

                            <select name="assigned_employee" class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">

                                <option disabled>Select employee</option>

                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ $project->assigned_employee == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }}
                                    </option>
                                @endforeach

                            </select>

                        @endif

                    </div>

                </div>

                <!-- DOCUMENTS -->
                @if($project->documents && count($project->documents) > 0)
                    <div class="mt-6">
                        <label class="text-sm text-gray-600">Current Documents</label>
                        <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-3 space-y-1">
                            @foreach($project->documents as $document)
                                <div class="text-sm text-gray-600">{{ basename($document) }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- UPLOAD -->
                <div class="mt-6">
                    <label class="text-sm text-gray-600">Upload New Documents</label>

                    <div
                        class="mt-2 border border-dashed border-gray-300 rounded-lg p-4 text-center text-sm text-gray-400 hover:border-[#AC7E2C] transition">
                        <input type="file" name="documents[]" multiple class="w-full cursor-pointer">
                        <p class="mt-1 text-xs">Upload Excel files (.xlsx, .xls)</p>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ url()->previous() }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Cancel
                    </a>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-[#AC7E2C] text-white hover:bg-[#8C651F]">
                        Update Project
                    </button>
                </div>

            </form>

        </div>

    </section>
@endsection