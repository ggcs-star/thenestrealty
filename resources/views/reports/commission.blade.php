@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 pt-10 pb-6">
        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Partner Commission Report</h2>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}"
                                class="text-gray-500 hover:text-[#AA7F2A] inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-500 ml-1 md:ml-2 text-sm font-medium">Partner Commission
                                    Report</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
           
        </div>

        {{-- Summary Cards --}}
     <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <!-- Total Commission -->
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 h-[90px] flex flex-col justify-between">        <p class="text-yellow-700 text-xs mb-1">Total Commission</p>
        <h3 class="text-xl font-bold text-yellow-900">
            ₹ {{ amountToPoints($totalCommission) }}
        </h3>
    </div>

    <!-- Partners -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
        <p class="text-green-700 text-xs mb-1">Partners</p>
        <h3 class="text-xl font-bold text-green-900">
            {{ $totalPartners }}
        </h3>
    </div>

    <!-- Paid -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <p class="text-blue-700 text-xs mb-1">Paid</p>
        <h3 class="text-xl font-bold text-blue-900">
            ₹ {{ amountToPoints($paid) }}
        </h3>
    </div>

    <!-- Pending -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-red-700 text-xs mb-1">Pending</p>
        <h3 class="text-xl font-bold text-red-900">
            ₹ {{ amountToPoints($pending) }}
        </h3>
    </div>

</div>

        {{-- Filter Section --}}
        <div class="bg-white rounded-xl shadow-md mb-6 border border-gray-100">
            <div class="p-4">
                <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="searchInput"
                                class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#AA7F2A] focus:border-[#AA7F2A]"
                                placeholder="Partner, Project..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="from_date"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#AA7F2A] focus:border-[#AA7F2A]"
                            value="{{ request('from_date') }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="to_date"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#AA7F2A] focus:border-[#AA7F2A]"
                            value="{{ request('to_date') }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#AA7F2A] focus:border-[#AA7F2A]">
                            <option value="">All</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 px-3 py-2 bg-[#AA7F2A] text-white text-sm rounded-lg hover:bg-[#8E6A22] transition flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('report.commissions') }}"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Active Filters --}}
                @if(request('search') || request('from_date') || request('to_date') || request('status'))
                    <div class="mt-3 pt-3 border-t border-gray-200 flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-gray-600">Filters:</span>
                        @if(request('search'))
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-[#AA7F2A] bg-opacity-10 text-[#AA7F2A] rounded-full text-xs">
                                {{ request('search') }}
                            </span>
                        @endif
                        @if(request('from_date') || request('to_date'))
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-[#AA7F2A] bg-opacity-10 text-[#AA7F2A] rounded-full text-xs">
                                {{ request('from_date') ?? 'Start' }} - {{ request('to_date') ?? 'End' }}
                            </span>
                        @endif
                        @if(request('status'))
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-[#AA7F2A] bg-opacity-10 text-[#AA7F2A] rounded-full text-xs">
                                {{ ucfirst(request('status')) }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Results --}}
        <div class="mb-3">
            <p class="text-sm text-gray-600">Showing <span
                    class="font-semibold text-[#AA7F2A]">{{ $grouped->count() }}</span> partners</p>
        </div>

        {{-- Partner Cards --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            @forelse($grouped as $partnerData)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    {{-- Partner Header --}}
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="bg-[#AA7F2A] bg-opacity-10 rounded-full p-2">
                                    <svg class="w-6 h-6 text-[#AA7F2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">
                                        {{ $partnerData['partner']->partner_name ?? $partnerData['partner']->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $partnerData['projects']->count() }} Projects •
                                        {{ $partnerData['items_count'] }} Items</p>
                                </div>
                            </div>
                            <div class="bg-[#AA7F2A] text-white px-3 py-1.5 rounded-lg">
                                <span class="font-bold text-sm">₹ {{ amountToPoints($partnerData['total']) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            <div class="bg-green-50 rounded p-1.5 text-center">
                                <p class="text-xs text-green-600">Paid</p>
                                <p class="text-sm font-bold text-green-700">₹ {{ amountToPoints($partnerData['paid']) }}</p>
                            </div>
                            <div class="bg-yellow-50 rounded p-1.5 text-center">
                                <p class="text-xs text-yellow-600">Pending</p>
                                <p class="text-sm font-bold text-yellow-700">₹ {{ amountToPoints($partnerData['pending']) }}</p>
                            </div>
                            <div class="bg-blue-50 rounded p-1.5 text-center">
                                <p class="text-xs text-blue-600">Projects</p>
                                <p class="text-sm font-bold text-blue-700">{{ $partnerData['projects']->count() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Projects --}}
                    <div class="p-3 space-y-2">
                        @foreach($partnerData['projects'] as $projectData)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 px-3 py-2 border-b border-gray-200 flex justify-between items-center cursor-pointer"
                                    onclick="toggleProjectItems(this)">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#AA7F2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span
                                            class="font-medium text-sm text-gray-800">{{ $projectData['project']->name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">({{ $projectData['items']->count() }})</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-[#AA7F2A]">₹
                                            {{ amountToPoints($projectData['total']) }}</span>
                                        <svg class="w-4 h-4 transform transition-transform text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="project-items hidden divide-y divide-gray-100">
                                    @foreach($projectData['items'] as $item)
                                        <div class="px-3 py-2 hover:bg-gray-50 transition flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm text-gray-700">{{ $item->booking_id }}</span>
                                                <span class="text-sm text-gray-700">{{ $item->unit_name }}</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                                    {{ $item->payment_status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($item->payment_status == 'confirmed')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        @endif
                                                    </svg>
                                                    {{ ucfirst($item->payment_status) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-sm text-[#AA7F2A]">₹
                                                {{ amountToPoints($item->amount) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
     
                        @endforeach
                    </div>
       <a href="{{ route('partner.commission.report', $partnerData['partner']->id) }}"
   class="inline-block text-xs font-semibold px-4 py-1.5 rounded-md text-white 
          bg-[#AA7C2A] hover:bg-[#94691F] 
          focus:outline-none focus:ring-2 focus:ring-[#AA7C2A]/50 
          transition shadow-sm">
    View Report
</a>


                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-md p-8 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-600 mb-1">No Records Found</h3>
                        <p class="text-sm text-gray-500 mb-3">Try adjusting your filters</p>
                        <a href="{{ route('report.commissions') }}"
                            class="inline-flex items-center gap-1 px-4 py-1.5 bg-[#AA7F2A] text-white text-sm rounded-lg hover:bg-[#8E6A22] transition">
                            Reset Filters
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Summary Modal --}}
    <dialog id="summaryModal" class="rounded-xl shadow-xl p-0 backdrop:bg-black backdrop:bg-opacity-50">
        <div class="w-full max-w-md">
            <div class="bg-gradient-to-r from-[#AA7F2A] to-[#8E6A22] text-white p-4 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Commission Summary</h3>
                    <button onclick="summaryModal.close()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-4 bg-white rounded-b-xl">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                        <p class="text-xs text-gray-600">Total</p>
                        <p class="text-xl font-bold text-[#AA7F2A]">₹ {{ amountToPoints($totalCommission) }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                        <p class="text-xs text-gray-600">Partners</p>
                        <p class="text-xl font-bold text-[#AA7F2A]">{{ $totalPartners }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                        <p class="text-xs text-gray-600">Paid</p>
                        <p class="text-xl font-bold text-green-600">₹ {{ amountToPoints($paid) }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $totalCommission > 0 ? round(($paid / $totalCommission) * 100) : 0 }}%</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                        <p class="text-xs text-gray-600">Pending</p>
                        <p class="text-xl font-bold text-orange-600">₹ {{ amountToPoints($pending) }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $totalCommission > 0 ? round(($pending / $totalCommission) * 100) : 0 }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <style>
        @media print {

            button,
            form,
            nav,
            dialog {
                display: none !important;
            }

            .shadow-md,
            .shadow-lg {
                box-shadow: none !important;
            }

            .bg-gradient-to-br,
            .bg-gradient-to-r {
                background: none !important;
                color: black !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide alerts
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000);

            // Set default arrow states for collapsed projects
            document.querySelectorAll('.project-items').forEach(items => {
                const arrow = items.closest('.border-gray-200')?.querySelector('svg:last-child');
                if (arrow) {
                    arrow.style.transform = 'rotate(-90deg)';
                }
            });
        });

        // Summary Modal close on outside click
        document.getElementById('summaryModal').addEventListener('click', function (e) {
            if (e.target === this) this.close();
        });

        // Filter form validation
        document.getElementById('filterForm').addEventListener('submit', function (e) {
            const searchInput = document.getElementById('searchInput');
            const fromDate = document.querySelector('input[name="from_date"]');
            const toDate = document.querySelector('input[name="to_date"]');

            // Trim search input
            if (searchInput) {
                searchInput.value = searchInput.value.trim();
            }

            // Date validation
            if (fromDate.value && toDate.value && fromDate.value > toDate.value) {
                e.preventDefault();
                alert('From date cannot be greater than To date');
                return false;
            }
        });

        // Real-time search with debounce (optional - submit on typing after delay)
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            // Uncomment below line if you want auto-submit after typing
            // searchTimeout = setTimeout(() => document.getElementById('filterForm').submit(), 500);
        });

        // Toggle project items visibility
        function toggleProjectItems(element) {
            const projectDiv = element.closest('.border-gray-200');
            const itemsDiv = projectDiv.querySelector('.project-items');
            const arrow = element.querySelector('svg:last-child');

            // Toggle display
            if (itemsDiv.classList.contains('hidden')) {
                itemsDiv.classList.remove('hidden');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                itemsDiv.classList.add('hidden');
                arrow.style.transform = 'rotate(-90deg)';
            }
        }

        function toggleProjectItems(el) {
            document.querySelectorAll('.project-items').forEach(i => i.classList.add('hidden'));

            const parent = el.closest('.border');
            const items = parent.querySelector('.project-items');
            const arrow = el.querySelector('svg:last-child');

            items.classList.remove('hidden');

            document.querySelectorAll('.project-items svg').forEach(a => a.classList.remove('rotate-180'));
            arrow.classList.add('rotate-180');
        }
    </script>

@endsection