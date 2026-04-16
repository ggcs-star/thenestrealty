@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 py-6 max-w-7xl">
        
        {{-- Header Section --}}
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('loan.reports') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                      
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(173, 136, 68, 0.1) 0%, rgba(173, 136, 68, 0.2) 100%)">
                            <span style="color: #AD8844" class="font-medium">
                                {{ strtoupper(substr($employee->name ?? 'E', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">{{ $employee->name ?? 'Employee' }}</h2>
                            <p class="text-sm text-gray-500">{{ $employee->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Quick Stats --}}
                <div class="flex gap-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Loans</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $loans->total() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="text-2xl font-bold" style="color: #AD8844">
                            ₹ {{ amountToPoints($loans->sum('loan_amount'), 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            @php
                $totalAmount = $loans->sum('loan_amount');
                $approvedCount = $loans->where('loan_stage_id', 1)->count();
                $pendingCount = $loans->where('loan_stage_id', 2)->count();
                $rejectedCount = $loans->where('loan_stage_id', 3)->count();
                
                $approvedAmount = $loans->where('loan_stage_id', 1)->sum('loan_amount');
                $pendingAmount = $loans->where('loan_stage_id', 2)->sum('loan_amount');
                $rejectedAmount = $loans->where('loan_stage_id', 3)->sum('loan_amount');
            @endphp

            {{-- Total Card --}}
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl shadow-sm border border-amber-200 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 rounded-lg" style="background-color: rgba(173, 136, 68, 0.1)">
                        <svg class="w-5 h-5" style="color: #AD8844" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold" style="color: #AD8844">₹ {{ amountToPoints($totalAmount, 2) }}</div>
                <p class="text-sm text-gray-600 mt-1">Total Loan Amount</p>
            </div>

            {{-- Approved Card --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-sm border border-green-200 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                        {{ $loans->total() > 0 ? round(($approvedCount / $loans->total()) * 100) : 0 }}%
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</div>
                <p class="text-sm text-gray-600 mt-1">Approved Loans</p>
                <div class="mt-2 pt-2 border-t border-green-200">
                    <span class="text-sm text-gray-600">Amount:</span>
                    <span class="text-sm font-semibold text-green-700 ml-1">₹ {{ amountToPoints($approvedAmount, 2) }}</span>
                </div>
            </div>

            {{-- Pending Card --}}
            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl shadow-sm border border-yellow-200 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                        {{ $loans->total() > 0 ? round(($pendingCount / $loans->total()) * 100) : 0 }}%
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</div>
                <p class="text-sm text-gray-600 mt-1">Pending Loans</p>
                <div class="mt-2 pt-2 border-t border-yellow-200">
                    <span class="text-sm text-gray-600">Amount:</span>
                    <span class="text-sm font-semibold text-yellow-700 ml-1">₹ {{ amountToPoints($pendingAmount, 2) }}</span>
                </div>
            </div>

            {{-- Rejected Card --}}
            <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl shadow-sm border border-red-200 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded-full">
                        {{ $loans->total() > 0 ? round(($rejectedCount / $loans->total()) * 100) : 0 }}%
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $rejectedCount }}</div>
                <p class="text-sm text-gray-600 mt-1">Rejected Loans</p>
                <div class="mt-2 pt-2 border-t border-red-200">
                    <span class="text-sm text-gray-600">Amount:</span>
                    <span class="text-sm font-semibold text-red-700 ml-1">₹ {{ amountToPoints($rejectedAmount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Filters Card --}}
        

        {{-- Data Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bank</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stage</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
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
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center" 
                                             style="background: linear-gradient(135deg, rgba(173, 136, 68, 0.1) 0%, rgba(173, 136, 68, 0.2) 100%)">
                                            <span style="color: #AD8844" class="font-medium text-sm">
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold" style="color: #AD8844">₹ {{ amountToPoints($loan->loan_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full border {{ $stageColor }}">
                                        {{ ucfirst($stageName) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $loan->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="#" class="font-medium hover:underline transition-colors" style="color: #AD8844">
                                        View Details →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background-color: rgba(173, 136, 68, 0.05)">
                                            <svg class="w-8 h-8" style="color: #AD8844" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            {{-- Summary Footer --}}
            @if($loans->count() > 0)
                <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">
                            Showing <span class="font-semibold">{{ $loans->firstItem() ?? 0 }}</span> to 
                            <span class="font-semibold">{{ $loans->lastItem() ?? 0 }}</span> of 
                            <span class="font-semibold">{{ $loans->total() }}</span> loans
                        </span>
                        <span class="text-sm text-gray-600">
                            Page Total: <span class="font-semibold" style="color: #AD8844">₹ {{ amountToPoints($loans->sum('loan_amount'), 2) }}</span>
                        </span>
                    </div>
                </div>
            @endif

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

{{-- Custom Styles --}}
<style>
    /* Focus ring with brand color */
    input:focus, select:focus {
        --tw-ring-color: rgba(173, 136, 68, 0.2);
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        border-color: #AD8844;
    }
    
    /* Pagination styling */
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
        background: #AD8844;
        color: white;
        border-color: #AD8844;
    }
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #AD8844;
        border-radius: 3px;
        opacity: 0.5;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #8B6B2E;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endsection