@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 py-6 max-w-7xl">
        
      

        {{-- Summary Statistics --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            
            {{-- Total Loans Card --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Total</span>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($total) }}</div>
                <p class="text-sm text-gray-600 mt-1">Total Loans</p>
                <div class="mt-3 text-sm">
                    <span class="text-gray-600">Total Value:</span>
                    <span class="font-semibold text-gray-900">₹ {{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>

            {{-- Dynamic Stage Cards --}}
            @foreach($stageCounts->take(3) as $index => $stage)
                @php
                    $colors = [
                        0 => ['bg' => 'from-green-50 to-emerald-50', 'border' => 'border-green-100', 'iconBg' => 'bg-green-100', 'iconColor' => 'text-green-600', 'badgeBg' => 'bg-green-100', 'badgeColor' => 'text-green-600'],
                        1 => ['bg' => 'from-yellow-50 to-amber-50', 'border' => 'border-yellow-100', 'iconBg' => 'bg-yellow-100', 'iconColor' => 'text-yellow-600', 'badgeBg' => 'bg-yellow-100', 'badgeColor' => 'text-yellow-600'],
                        2 => ['bg' => 'from-red-50 to-rose-50', 'border' => 'border-red-100', 'iconBg' => 'bg-red-100', 'iconColor' => 'text-red-600', 'badgeBg' => 'bg-red-100', 'badgeColor' => 'text-red-600'],
                    ][$index] ?? ['bg' => 'from-gray-50 to-gray-100', 'border' => 'border-gray-100', 'iconBg' => 'bg-gray-100', 'iconColor' => 'text-gray-600', 'badgeBg' => 'bg-gray-100', 'badgeColor' => 'text-gray-600'];
                @endphp
                
                <div class="bg-gradient-to-br {{ $colors['bg'] }} rounded-xl shadow-sm border {{ $colors['border'] }} p-5 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 {{ $colors['iconBg'] }} rounded-lg">
                            @if($stage['name'] == 'approved')
                                <svg class="w-5 h-5 {{ $colors['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($stage['name'] == 'pending')
                                <svg class="w-5 h-5 {{ $colors['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 {{ $colors['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-xs font-medium {{ $colors['badgeColor'] }} {{ $colors['badgeBg'] }} px-2 py-1 rounded-full">
                            {{ $stage['percentage'] }}%
                        </span>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($stage['count']) }}</div>
                    <p class="text-sm text-gray-600 mt-1 capitalize">{{ $stage['name'] }} Loans</p>
                    <div class="mt-3 pt-3 border-t {{ $colors['border'] }}">
                        <span class="text-sm text-gray-600">Amount:</span>
                        <span class="text-sm font-semibold text-gray-900 ml-1">₹ {{ number_format($stage['amount'], 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filters Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Filters</h3>
                @if(request()->anyFilled(['search', 'stage', 'from_date', 'to_date']))
                    <span class="text-xs text-gray-500">{{ $total }} results found</span>
                @endif
            </div>
            
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" placeholder="Customer, Bank, Unit..." 
                                value="{{ request('search') }}"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    {{-- Stage Filter --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Stage</label>
                        <select name="stage" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Stages</option>
                            @foreach($stageCounts as $stage)
                                <option value="{{ $stage['id'] }}" {{ request('stage') == $stage['id'] ? 'selected' : '' }}>
                                    {{ ucfirst($stage['name']) }} ({{ $stage['count'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Date Range</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="from_date" value="{{ request('from_date') }}" 
                                class="flex-1 border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-gray-400">—</span>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" 
                                class="flex-1 border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="md:col-span-4 flex items-end gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Apply Filters
                        </button>
                        
                        <a href="{{ route('loan.reports') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </a>
                    </div>
                </div>
            </form>

            {{-- Active Filters Tags --}}
            @if(request()->anyFilled(['search', 'stage', 'from_date', 'to_date']))
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                    @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Search: {{ request('search') }}
                            <a href="{{ route('loan.reports', request()->except('search')) }}" class="ml-2 hover:text-blue-600">&times;</a>
                        </span>
                    @endif
                    @if(request('stage'))
                        @php $stageName = $stageCounts->firstWhere('id', request('stage'))['name'] ?? request('stage'); @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Stage: {{ ucfirst($stageName) }}
                            <a href="{{ route('loan.reports', request()->except('stage')) }}" class="ml-2 hover:text-purple-600">&times;</a>
                        </span>
                    @endif
                    @if(request('from_date') || request('to_date'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Date: {{ request('from_date', 'Start') }} - {{ request('to_date', 'End') }}
                            <a href="{{ route('loan.reports', request()->except(['from_date', 'to_date'])) }}" class="ml-2 hover:text-green-600">&times;</a>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bank</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stage</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($loans as $loan)
                            @php 
                                $stage = optional($loan->stage);
                                $stageName = $stage->name ?? 'pending';
                                
                                $stageColors = [
                                    'approved' => 'bg-green-100 text-green-800 border-green-200',
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                ];
                                $stageColor = $stageColors[$stageName] ?? $stageColors['pending'];
                            @endphp
                            
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                            <span class="text-blue-600 font-medium text-sm">
                                                {{ strtoupper(substr($loan->customer_name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $loan->customer_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $loan->unit_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $loan->bank_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $loan->employee->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">₹ {{ number_format($loan->loan_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full border {{ $stageColor }}">
                                        {{ ucfirst($stageName) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $loan->created_at->format('d M, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No loan records found</h3>
                                        <p class="text-gray-500 text-sm">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($loans->hasPages())
                <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                    {{ $loans->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Quick Date Range Script --}}
<script>
function setDateRange(range) {
    const today = new Date();
    let fromDate = new Date();
    let toDate = new Date();
    
    switch(range) {
        case 'today':
            fromDate = today;
            toDate = today;
            break;
        case 'week':
            fromDate.setDate(today.getDate() - 7);
            break;
        case 'month':
            fromDate.setMonth(today.getMonth() - 1);
            break;
    }
    
    document.querySelector('input[name="from_date"]').value = formatDate(fromDate);
    document.querySelector('input[name="to_date"]').value = formatDate(toDate);
    
    document.querySelector('form').submit();
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
</script>

{{-- Alpine.js for dropdown (include if not already in layout) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Custom Pagination Styling --}}
<style>
.pagination {
    display: flex;
    gap: 0.25rem;
}
.pagination .page-item {
    list-style: none;
}
.pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2rem;
    height: 2rem;
    padding: 0 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #4b5563;
    background: white;
    border: 1px solid #e5e7eb;
    transition: all 0.15s ease;
}
.pagination .page-link:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}
.pagination .active .page-link {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}
.pagination .disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection