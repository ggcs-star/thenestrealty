@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Partner Commission Details</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-[#AA7F2A] inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('report.commissions') }}" class="text-gray-500 hover:text-[#AA7F2A] ml-1 md:ml-2 text-sm font-medium">Commission Report</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-500 ml-1 md:ml-2 text-sm font-medium">{{ $partner->partner_name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('report.commissions') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
         
        </div>
    </div>

    {{-- Partner Summary Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    {{-- Partner Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex items-center gap-4">
        <div class="bg-gray-100 rounded-full p-3">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Partner</p>
            <h3 class="text-lg font-semibold text-gray-800">{{ $partner->partner_name }}</h3>
        </div>
    </div>

    {{-- Total Commission --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
        <p class="text-sm text-gray-500 mb-1">Total Commission</p>
        <h3 class="text-2xl font-bold text-gray-900">₹ {{ amountToPoints($total) }}</h3>
    </div>

    {{-- Paid --}}
    <div class="bg-green-50 border border-green-100 rounded-xl shadow-sm p-5">
        <p class="text-sm text-green-700 mb-1">Paid</p>
        <h3 class="text-2xl font-bold text-green-700">₹ {{ amountToPoints($paid) }}</h3>
        <p class="text-xs text-green-600 mt-1">
            {{ $total > 0 ? round(($paid/$total)*100) : 0 }}% completed
        </p>
    </div>

    {{-- Pending --}}
    <div class="bg-orange-50 border border-orange-100 rounded-xl shadow-sm p-5">
        <p class="text-sm text-orange-700 mb-1">Pending</p>
        <h3 class="text-2xl font-bold text-orange-700">₹ {{ amountToPoints($pending) }}</h3>
        <p class="text-xs text-orange-600 mt-1">
            {{ $total > 0 ? round(($pending/$total)*100) : 0 }}% remaining
        </p>
    </div>

</div>

{{-- SECOND ROW --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

    {{-- Projects --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
        <p class="text-sm text-gray-500 mb-1">Total Projects</p>
        <h3 class="text-2xl font-bold text-gray-900">{{ $projects->count() }}</h3>
    </div>

    {{-- Bookings --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
        <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
        <h3 class="text-2xl font-bold text-gray-900">
            {{ $projects->sum(fn($p) => $p['bookings']->count()) }}
        </h3>
    </div>

</div>

    {{-- Projects List --}}
    <div class="space-y-4">
        @foreach($projects as $index => $project)
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            {{-- Project Header --}}
            <div class="p-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition" onclick="toggleProjectDetails(this)">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#AA7F2A] bg-opacity-10 rounded-lg p-2">
                            <svg class="w-6 h-6 text-[#AA7F2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">{{ $project['project_name'] }}</h4>
                            <p class="text-xs text-gray-500">{{ $project['bookings']->count() }} Bookings</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-2 sm:mt-0">
                        <div class="text-right">
                            <p class="text-xl font-bold text-[#AA7F2A]">₹ {{ amountToPoints($project['total']) }}</p>
                            <div class="flex gap-3 text-xs">
                                <span class="text-green-600">Paid: ₹ {{ amountToPoints($project['paid']) }}</span>
                                <span class="text-yellow-600">Pending: ₹ {{ amountToPoints($project['pending']) }}</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 transform transition-transform text-gray-400 {{ $index === 0 ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Bookings Table --}}
            <div class="project-details" style="{{ $index === 0 ? '' : 'display: none;' }}">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Commission %</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($project['bookings'] as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Booking ID --}}
                                <td class="px-4 py-3">
                                    <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                        #{{ $booking['booking_id'] }}
                                        
                                    </span>
                                </td>
                                
                                {{-- Customer --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-gray-800">{{ $booking['customer'] }}</span>
                                    </div>
                                </td>
                                
                                {{-- Unit --}}
                                <td class="px-4 py-3">
                                    <span class="text-gray-700">{{ $booking['unit'] }}</span>
                                </td>
                                
                                {{-- Date --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $booking['date'] }}</span>
                                    </div>
                                </td>
                                
                                {{-- Total Amount --}}
                                <td class="px-4 py-3 text-right">
                                    <span class="text-gray-700">₹ {{ amountToPoints($booking['total_amount'] ?? 0) }}</span>
                                </td>
                                
                                {{-- Commission Rate --}}
                                <td class="px-4 py-3 text-right">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">
                                        {{ $booking['commission_rate'] ?? 0 }}%
                                    </span>
                                </td>
                                
                                {{-- Commission Amount --}}
                                <td class="px-4 py-3 text-right">
                                    <span class="font-bold text-[#AA7F2A]">₹ {{ amountToPoints($booking['amount']) }}</span>
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                        {{ $booking['status'] == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($booking['status'] == 'confirmed')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                        {{ ucfirst($booking['status']) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Project Summary Footer --}}
                        <tfoot class="bg-gray-50 border-t border-gray-200">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-600">Project Total:</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-gray-800">-</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-gray-800">-</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-[#AA7F2A]">₹ {{ amountToPoints($project['total']) }}</td>
                                <td class="px-4 py-3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- No Projects Message --}}
    @if($projects->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-600 mb-1">No Projects Found</h3>
        <p class="text-sm text-gray-500">This partner has no commission records yet.</p>
    </div>
    @endif
</div>

<style>
    @media print {
        button, nav, .breadcrumb { display: none !important; }
        .shadow-md, .shadow-lg { box-shadow: none !important; }
        .bg-gradient-to-r { background: none !important; color: black !important; }
        .project-details { display: block !important; }
        table { border: 1px solid #ddd; }
        th { background-color: #f9f9f9 !important; color: black !important; }
    }
</style>

<script>
function toggleProjectDetails(element) {
    const projectDiv = element.closest('.bg-white');
    const detailsDiv = projectDiv.querySelector('.project-details');
    const arrow = element.querySelector('svg:last-child');
    
    if (detailsDiv.style.display === 'none') {
        detailsDiv.style.display = 'block';
        arrow.style.transform = 'rotate(180deg)';
    } else {
        detailsDiv.style.display = 'none';
        arrow.style.transform = 'rotate(0deg)';
    }
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 3000);
});
</script>

@endsection