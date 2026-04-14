@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Channel Partners</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage and track all channel partner relationships</p>
                </div>
                <a href="{{ route('partner.create') }}" 
   class="inline-flex items-center justify-center gap-2 bg-[#AC7E2C] text-white px-5 py-2.5 rounded-lg hover:bg-[#8C651F] transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add New Partner</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Partners</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $partners->total() ?? $partners->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Partners</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $partners->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Inactive Partners</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $partners->where('status', 'inactive')->count() }}</p>
                    </div>
                    <div class="bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">New This Month</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $partners->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-6">
            <div class="px-6 py-4 border-b bg-gray-50 rounded-t-lg">
                <h2 class="text-sm font-semibold text-gray-700">Search & Filter Partners</h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('partner.list') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-5">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name, email, or contact number..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" 
                                   name="from"
                                   id="from"
                                   value="{{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('Y-m-d') : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" 
                                   name="to"
                                   id="to"
                                   value="{{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('Y-m-d') : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="flex gap-3 mt-4">
<button type="submit" class="bg-[#AC7E2C] text-white px-6 py-2 rounded-lg hover:bg-[#8C651F] transition-colors font-medium">                            Apply Filters
                        </button>
                        <a href="{{ route('partner.list') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Partners Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Information</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($partners as $partner)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-medium text-sm">
                                                {{ strtoupper(substr($partner->partner_name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $partner->partner_name }}</div>
                                        <div class="text-xs text-gray-500">
                                            DOB: {{ \Carbon\Carbon::parse($partner->date_of_birth)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $partner->mail_id }}</div>
                                <div class="text-sm text-gray-500">{{ $partner->number_contact }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">Aadhaar: {{ $partner->aadhaar_card }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $partner->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($partner->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('partner.edit', $partner->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('partner.toggleStatus', $partner->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('partner.destroy', $partner->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this partner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No partners found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new partner.</p>
                                    <div class="mt-6">
<a href="{{ route('partner.create') }}" 
   class="inline-flex items-center justify-center gap-2 bg-[#AC7E2C] text-white px-5 py-2.5 rounded-lg hover:bg-[#8C651F] transition-colors shadow-sm">                                            Add New Partner
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($partners) && method_exists($partners, 'hasPages') && $partners->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Showing 
                        <span class="font-medium">{{ $partners->firstItem() }}</span> 
                        to 
                        <span class="font-medium">{{ $partners->lastItem() }}</span> 
                        of 
                        <span class="font-medium">{{ $partners->total() }}</span> 
                        results
                    </div>
                    <div>
                        {{ $partners->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
            @elseif(isset($partners) && $partners->count() > 0)
            <div class="bg-gray-50 px-6 py-4 border-t">
                <div class="text-sm text-gray-600 text-center">
                    Showing all <span class="font-medium">{{ $partners->count() }}</span> results
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Auto-submit form when filters change (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const fromDate = document.getElementById('from');
        const toDate = document.getElementById('to');
        
        function submitForm() {
            document.getElementById('filterForm').submit();
        }
        
        // Uncomment below to enable auto-submit on filter change
        // if (statusSelect) statusSelect.addEventListener('change', submitForm);
        // if (fromDate) fromDate.addEventListener('change', submitForm);
        // if (toDate) toDate.addEventListener('change', submitForm);
    });
</script>
@endpush
@endsection