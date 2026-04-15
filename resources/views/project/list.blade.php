@extends('layouts.app')

@section('content')
@php $hideDashboard = true; @endphp

<section class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-7xl mx-auto">
    
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Projects</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and track all your real estate projects</p>
            </div>
            <a href="{{ route('projects.create') }}" 
class="inline-flex items-center justify-center gap-2 bg-[#AC7E2C] text-white px-4 py-2 rounded-lg hover:bg-[#8C651F] transition-colors shadow-sm">                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>New Project</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg border p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Projects</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $projects->total() }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Projects</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $projects->where('status', 'Active')->count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Units</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $projects->sum('ex_unit') }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">${{ amountToPoints($projects->sum('value') ?? 0) }}</p>
                </div>
                <div class="bg-orange-50 rounded-lg p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg border mb-8">
        <div class="border-b px-6 py-3">
            <h2 class="text-sm font-semibold text-gray-700">Filter Projects</h2>
        </div>
        <div class="p-6">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Project name or builder..." 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @if(!auth('employee')->check())
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Employee</label>
                        <select name="employee_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Employees</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="flex items-end gap-2">
<button type="submit" class="flex-1 bg-[#AC7E2C] text-white px-4 py-2 rounded-lg hover:bg-[#8C651F] transition-colors">                            Apply Filters
                        </button>
                        <a href="{{ route('projects.list') }}" class="flex-1 text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Projects List -->
    <div class="space-y-4">
        @forelse ($projects as $project)
        <div class="bg-white rounded-lg border hover:shadow-md transition-shadow">
            <!-- Project Header -->
            <div class="p-5 border-b">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                    <div class="flex-1">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $project->name }}</h3>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $project->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $project->status }}
                                    </span>
                                    <span class="text-xs text-gray-500">ID: {{ $project->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('projects.edit', $project->id) }}" 
                           class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="p-5 border-b">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Builder</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $project->builder_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Contact</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $project->builder_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Assigned To</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $project->employee->name ?? 'Unassigned' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Units</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $project->ex_unit }} units</p>
                    </div>
                </div>
            </div>

            <!-- Units Section -->
            <div x-data="{ open: false }" class="bg-gray-50 rounded-b-lg">
                <button @click="open = !open" 
                        class="w-full px-5 py-3 flex items-center justify-between hover:bg-gray-100 transition-colors rounded-b-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">View Units</span>
                        <span class="text-xs text-gray-500">
                            ({{ count($project->booked_units ?? []) }}/{{ $project->ex_unit }} booked)
                        </span>
                    </div>
                    <svg x-show="!open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </button>

                <div x-show="open" x-collapse class="px-5 pb-5">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Booking Progress</span>
                            <span class="font-medium text-gray-900">
                                {{ round((count($project->booked_units ?? []) / max($project->ex_unit, 1)) * 100) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ round((count($project->booked_units ?? []) / max($project->ex_unit, 1)) * 100) }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Units Grid -->
                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-12 gap-2 max-h-64 overflow-y-auto">
                        @foreach($project->units as $unit)
                            @php
                                $isBooked = in_array($unit, $project->booked_units ?? []);
                            @endphp
                            <div class="text-center p-2 rounded border text-sm
                                {{ $isBooked ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700' }}">
                                {{ $unit }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="flex gap-4 mt-4 pt-3 border-t">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600">
                                Available: <span class="font-semibold text-green-700">{{ count($project->available_units) }}</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-600">
                                Booked: <span class="font-semibold text-red-700">{{ count($project->booked_units) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg border p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No projects found</h3>
            <p class="text-gray-500">Try adjusting your filters or create a new project.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
    @endif

</section>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
@endsection