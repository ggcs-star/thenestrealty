@extends('layouts.app')

@section('content')
    @php $hideDashboard = true; @endphp

    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Project List') }}
            </h2>
        </header>

        <div class="w-full mt-6 space-y-6">
            @foreach ($projects as $project)
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                    <!-- Project Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $project->name }}</h3>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $project->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-300 text-gray-800' }}">
                                    {{ $project->status }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('projects.edit', $project->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Project Details -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Builder:</span> {{ $project->builder_name }}
                            </div>
                            <div>
                                <span class="font-medium">Contact:</span> {{ $project->builder_number }}
                            </div>
                            <div>
                                <span class="font-medium">Assigned To:</span> {{ $project->employee->name ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="font-medium">Total Units:</span> {{ $project->ex_unit }}
                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="p-6">
                        <button @click="open = !open"
                            class="mb-4 text-left w-full flex items-center justify-between px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            <span class="text-lg font-medium text-gray-800">Unit Availability</span>
                            <svg :class="{'transform rotate-180': open}" class="w-5 h-5 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="space-y-4">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                @foreach($project->units as $unit)
                                                @php
                                                    $isBooked = in_array($unit, $project->booked_units ?? []);
                                                @endphp
                                                <div class="p-3 rounded-lg border text-center text-sm font-medium
                                            {{ $isBooked
                                    ? 'bg-red-100 border-red-300 text-red-700'
                                    : 'bg-green-100 border-green-300 text-green-700' }}">
                                                    {{ $unit }}
                                                    <div class="text-xs mt-1">
                                                        {{ $isBooked ? 'Booked' : 'Available' }}
                                                    </div>
                                                </div>
                                @endforeach
                            </div>

                            <!-- Summary -->
                            <div class="mt-4 flex items-center space-x-6 text-sm">
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-green-100 border border-green-300 rounded"></div>
                                    <span>Available: {{ count($project->available_units) }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-red-100 border border-red-300 rounded"></div>
                                    <span>Booked: {{ count($project->booked_units) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Units Modal -->
    <div id="unitsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Project Units</h3>
                    <button onclick="closeUnitsModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <div id="unitsList" class="max-h-60 overflow-y-auto">
                    <!-- Units will be populated here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUnits(projectId, units) {
            const modal = document.getElementById('unitsModal');
            const unitsList = document.getElementById('unitsList');

            let unitsHtml = '<div class="space-y-2">';
            units.forEach((unit, index) => {
                unitsHtml += `<div class="p-2 bg-gray-50 rounded border">${index + 1}. ${unit}</div>`;
            });
            unitsHtml += '</div>';

            unitsList.innerHTML = unitsHtml;
            modal.classList.remove('hidden');
        }

        function closeUnitsModal() {
            const modal = document.getElementById('unitsModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('unitsModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeUnitsModal();
            }
        });
    </script>
@endsection