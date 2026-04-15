@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow border">
            <p class="text-gray-500 text-sm">Total Loans</p>
            <h3 class="text-2xl font-bold">{{ $total }}</h3>
        </div>

        <div class="bg-green-50 p-4 rounded-xl shadow border">
            <p class="text-green-600 text-sm">Approved</p>
            <h3 class="text-2xl font-bold text-green-700">{{ $approved }}</h3>
        </div>

        <div class="bg-yellow-50 p-4 rounded-xl shadow border">
            <p class="text-yellow-600 text-sm">Pending</p>
            <h3 class="text-2xl font-bold text-yellow-700">{{ $pending }}</h3>
        </div>

        <div class="bg-red-50 p-4 rounded-xl shadow border">
            <p class="text-red-600 text-sm">Rejected</p>
            <h3 class="text-2xl font-bold text-red-700">{{ $rejected }}</h3>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white p-4 rounded-xl shadow border mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            {{-- Search Input --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Search</label>
                <input type="text" name="search" placeholder="Customer, Bank, Unit..." 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('search') }}">
            </div>

            {{-- Stage Filter --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Stage</label>
                <select name="stage" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Stages</option>
                    <option value="approved" {{ request('stage') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('stage') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('stage') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            {{-- From Date --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">From Date</label>
                <input type="date" name="from_date" 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('from_date') }}">
            </div>

            {{-- To Date --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">To Date</label>
                <input type="date" name="to_date" 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('to_date') }}">
            </div>

            {{-- Filter Button --}}
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Apply Filters
                </button>
            </div>

            {{-- Clear Button --}}
            <div class="flex items-end">
                <a href="{{ route('loan.reports') }}" 
                   class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-center transition duration-200">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    {{-- Active Filters Display --}}
    @if(request()->anyFilled(['search', 'stage', 'from_date', 'to_date']))
    <div class="mb-4 flex flex-wrap gap-2">
        <span class="text-sm text-gray-600 py-1">Active Filters:</span>
        @if(request('search'))
            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                Search: {{ request('search') }}
            </span>
        @endif
        @if(request('stage'))
            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                Stage: {{ ucfirst(request('stage')) }}
            </span>
        @endif
        @if(request('from_date') || request('to_date'))
            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                Date: {{ request('from_date', 'Start') }} - {{ request('to_date', 'End') }}
            </span>
        @endif
    </div>
    @endif

    {{-- Results Count --}}
    <div class="mb-4 text-sm text-gray-600">
        Showing {{ $loans->firstItem() ?? 0 }} - {{ $loans->lastItem() ?? 0 }} of {{ $loans->total() }} results
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stage</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $loan->customer_name }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                {{ $loan->unit_name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                {{ $loan->bank_name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                {{ $loan->employee->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="font-medium text-gray-900">₹ {{ amountToPoints($loan->loan_amount, 2) }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    {{ $loan->loan_stage == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $loan->loan_stage == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $loan->loan_stage == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($loan->loan_stage) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                {{ $loan->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">No loan records found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $loans->withQueryString()->links() }}
    </div>
</div>
@endsection