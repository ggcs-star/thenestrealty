@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gray-50 py-6 sm:py-8 px-3 sm:px-4 lg:px-6">
    <div class="w-full max-w-full mx-auto">
        
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Booking List</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">Manage and track all property bookings</p>
                </div>
                <a href="{{ route('bookings.create') }}" 
class="inline-flex items-center justify-center gap-2 bg-[#AC7E2C] text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg hover:bg-[#8C651F] transition-colors shadow-sm text-sm sm:text-base">                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add New Booking</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div class="bg-white rounded-lg border p-3 sm:p-4 lg:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Bookings</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mt-1">{{ $totalBookings ?? $bookings->total() ?? $bookings->count() }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="text-xs text-gray-400">Total registered bookings</div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-3 sm:p-4 lg:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Booked</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold text-green-600 mt-1">{{ $totalBooked ?? \App\Models\Booking::where('status', 'booked')->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="text-xs text-gray-400">Successfully booked</div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-3 sm:p-4 lg:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold text-yellow-600 mt-1">{{ $totalPending ?? \App\Models\Booking::where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="text-xs text-gray-400">Awaiting confirmation</div>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-3 sm:p-4 lg:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-base sm:text-lg lg:text-xl font-bold text-purple-600 mt-1 truncate">{{ amountToPoints($totalRevenue ?? \App\Models\Booking::sum('total_amount')) }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="text-xs text-gray-400">Total revenue generated</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-lg border shadow-sm mb-6">
            <div class="px-3 sm:px-4 py-3 border-b">
                <h2 class="text-xs sm:text-sm font-semibold text-gray-700">Search & Filter Bookings</h2>
            </div>
            <div class="p-3 sm:p-4">
                <form method="GET" action="{{ route('bookings.list') }}" class="space-y-3">
                    <div class="w-full">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by Booking ID, Customer, Project, or Unit..." 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">All Status</option>
                            <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>✅ Booked</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                        
                        <input type="date" name="from"
                            value="{{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('Y-m-d') : '' }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        
                        <input type="date" name="to"
                            value="{{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('Y-m-d') : '' }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        
                        <div class="flex gap-2">
                          <button type="submit" class="flex-1 bg-[#AC7E2C] text-white px-4 py-2 rounded-lg hover:bg-[#8C651F] transition-colors">                            Apply Filters
                        </button>
                            <a href="{{ route('bookings.list') }}" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-center text-sm font-medium">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-3 sm:px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs sm:text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Booking Table -->
        <div class="bg-white rounded-lg border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-[800px] lg:min-w-full w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Other</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-3 sm:px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $index => $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $bookings->firstItem() + $index }}
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-medium text-xs">
                                                {{ substr($booking->booking_id ?? 'BK', 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-2 sm:ml-3">
                                        <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $booking->booking_id ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-4 py-3">
                                <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $booking->customer->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500 hidden sm:block">{{ $booking->customer->email ?? '-' }}</div>
                            </td>
                            <td class="px-3 sm:px-4 py-3">
                                <div class="text-xs sm:text-sm text-gray-900">{{ $booking->project->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500 hidden sm:block">ID: {{ $booking->project_id ?? '-' }}</div>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="text-xs sm:text-sm text-gray-900">{{ $booking->channelPartner->partner_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex px-2 py-0.5 sm:py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                    {{ $booking->unit_name }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-semibold text-green-600">{{ amountToPoints($booking->invoice_amount) }}</span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-semibold text-yellow-600">{{ amountToPoints($booking->other_amount) }}</span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-bold text-blue-800">{{ amountToPoints($booking->total_amount) }}</span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 sm:py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ strtolower($booking->status) === 'booked' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ strtolower($booking->status) === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ strtolower($booking->status) === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('bookings.edit', $booking->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors p-1"
                                       title="Edit Booking">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this booking?')"
                                                class="text-red-600 hover:text-red-900 transition-colors p-1"
                                                title="Delete Booking">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="px-3 sm:px-4 py-8 sm:py-12 text-center">
                                <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500">Get started by creating a new booking.</p>
                                <div class="mt-4 sm:mt-6">
                                    <a href="{{ route('bookings.create') }}" 
                                       class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Add New Booking
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($bookings->lastPage() > 1)
            <div class="bg-gray-50 px-3 sm:px-4 py-3 sm:py-4 border-t">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-xs sm:text-sm text-gray-600 text-center sm:text-left">
                        Showing 
                        <span class="font-semibold text-gray-900">{{ $bookings->firstItem() }}</span> 
                        to 
                        <span class="font-semibold text-gray-900">{{ $bookings->lastItem() }}</span> 
                        of 
                        <span class="font-semibold text-gray-900">{{ $bookings->total() }}</span> 
                        results
                    </div>
                    <div class="flex justify-center">
                        {{ $bookings->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
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