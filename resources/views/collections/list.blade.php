@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Follow-ups & Collections</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage and track all payment collections</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg border p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Collections</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $collections->total() ?? $collections->count() }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $collections->where('status', 'Completed')->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $collections->where('status', 'Pending')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Amount</p>
                        <p class="text-xl font-bold text-purple-600 mt-1 truncate">{{ amountToPoints($collections->sum('amount')) }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-lg border shadow-sm mb-6">
            <div class="p-4 border-b">
                <h2 class="text-sm font-semibold text-gray-700">Search & Filter Collections</h2>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('collections.list') }}" class="space-y-3">
                    <div class="w-full">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by Customer Name, Booking ID, or Mode..." 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#AC7E2C] focus:border-[#AC7E2C] text-sm">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#AC7E2C] text-sm">
                            <option value="">All Status</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                        </select>
                        
                        <select name="mode" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#AC7E2C] text-sm">
                            <option value="">All Modes</option>
                            <option value="Cash" {{ request('mode') == 'Cash' ? 'selected' : '' }}>💵 Cash</option>
                            <option value="Cheque" {{ request('mode') == 'Cheque' ? 'selected' : '' }}>📝 Cheque</option>
                            <option value="Bank Transfer" {{ request('mode') == 'Bank Transfer' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                            <option value="Online" {{ request('mode') == 'Online' ? 'selected' : '' }}>💻 Online</option>
                        </select>
                        
                        <input type="date" name="from"
                            value="{{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('Y-m-d') : '' }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#AC7E2C] text-sm"
                            placeholder="From Date">
                        
                        <input type="date" name="to"
                            value="{{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('Y-m-d') : '' }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#AC7E2C] text-sm"
                            placeholder="To Date">
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F] transition-colors text-sm font-medium">
                            Apply Filters
                        </button>
                        <a href="{{ route('collections.list') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Collections Table -->
        <div class="bg-white rounded-lg border shadow-sm overflow-hidden">
            @if($collections->isEmpty())
                <div class="text-center py-12">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No collections found</h3>
                        <p class="mt-1 text-sm text-gray-500">No collection records available.</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-[800px] lg:min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($collections as $index => $collection)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $collections->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        @if($collection->mode == 'Cash') 💵
                                        @elseif($collection->mode == 'Cheque') 📝
                                        @elseif($collection->mode == 'Bank Transfer') 🏦
                                        @elseif($collection->mode == 'Online') 💻
                                        @else {{ $collection->mode }}
                                        @endif
                                        {{ $collection->mode }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($collection->date)->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-blue-800">{{ amountToPoints($collection->amount) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-[#AC7E2C] bg-opacity-10 flex items-center justify-center">
                                                <span class="text-[#AC7E2C] font-medium text-xs">
                                                    {{ strtoupper(substr($collection->customer->name ?? 'C', 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $collection->customer->name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $collection->booking->booking_id ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex items-center gap-1 text-xs font-semibold rounded-full
                                        {{ $collection->status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        <span class="w-1.5 h-1.5 rounded-full 
                                            {{ $collection->status === 'Completed' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                        {{ $collection->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('collections.edit', $collection->id) }}" 
                                           class="text-[#AC7E2C] hover:text-[#8C651F] transition-colors p-1"
                                           title="Edit Collection">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <!-- <form action="#" class="inline-block" -->
                                              <!-- onsubmit="return confirm('Are you sure you want to delete this collection record?')"> -->
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-1"
                                                    title="Delete Collection">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($collections->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-sm text-gray-600">
                            Showing 
                            <span class="font-semibold text-gray-900">{{ $collections->firstItem() }}</span> 
                            to 
                            <span class="font-semibold text-gray-900">{{ $collections->lastItem() }}</span> 
                            of 
                            <span class="font-semibold text-gray-900">{{ $collections->total() }}</span> 
                            results
                        </div>
                        <div>
                            {{ $collections->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fromInput = document.querySelector('input[name="from"]');
        const toInput = document.querySelector('input[name="to"]');

        if (fromInput && toInput) {
            toInput.addEventListener('change', function () {
                if (fromInput.value && toInput.value && fromInput.value > toInput.value) {
                    alert('End date must be after start date');
                    toInput.value = '';
                }
            });

            fromInput.addEventListener('change', function () {
                if (fromInput.value && toInput.value && fromInput.value > toInput.value) {
                    alert('Start date must be before end date');
                    fromInput.value = '';
                }
            });
        }
    });
</script>
@endpush
@endsection