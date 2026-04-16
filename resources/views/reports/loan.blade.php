@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="flex-1 p-4 sm:p-6 min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Loan Reports</h1>
            <p class="text-sm text-gray-500 mt-1">Better loan reporting with cleaner filters, summary insights, and a stronger preview layout.</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                This Month
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Total Loan Cases -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative">
            <div class="text-sm font-medium text-gray-500 mb-2 flex justify-between items-center">
                Total Loan Cases
                <span class="p-1.5 bg-gray-50 rounded-md border border-gray-100"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($totalLoans) }}</div>
            <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                Active Pipeline Volume
            </div>
        </div>

        <!-- Open Pipeline -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative">
            <div class="text-sm font-medium text-gray-500 mb-2 flex justify-between items-center">
                Open Pipeline
                <span class="p-1.5 bg-gray-50 rounded-md border border-gray-100"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
            </div>
            <div class="text-3xl font-bold text-gray-900">₹ {{ number_format($totalAmount, 2) }}</div>
            <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                Across active stages
            </div>
        </div>

        <!-- Dynamic Stages -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative">
            <div class="text-sm font-medium text-gray-500 mb-2 flex justify-between items-center">
                Dynamic Stages
                <span class="p-1.5 bg-gray-50 rounded-md border border-gray-100"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($dynamicStages) }}</div>
            <div class="text-xs text-yellow-600 font-medium mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                Custom per project / bank
            </div>
        </div>

        <!-- Disbursed Cases -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative">
            <div class="text-sm font-medium text-gray-500 mb-2 flex justify-between items-center">
                Disbursed / Completed
                <span class="p-1.5 bg-gray-50 rounded-md border border-gray-100"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($disbursedCases) }}</div>
            <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Ready for export
            </div>
        </div>
    </div>

    <!-- Report Builder Filters & Toggles -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Report Builder</h2>
                <p class="text-sm text-gray-500">Choose scope, filters, and display rules before generating the final loan report.</p>
            </div>
            <div class="mt-4 md:mt-0 bg-gray-100 p-1 rounded-lg flex space-x-1">
                <button onclick="switchTab('list')" id="btn-list" class="report-tab-btn bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm">Detailed List</button>
                <button onclick="switchTab('project')" id="btn-project" class="report-tab-btn bg-transparent text-gray-600 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium transition">Project Wise</button>
                <button onclick="switchTab('bank')" id="btn-bank" class="report-tab-btn bg-transparent text-gray-600 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium transition">Bank Wise</button>
                <button onclick="switchTab('customer')" id="btn-customer" class="report-tab-btn bg-transparent text-gray-600 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium transition">Customer Wise</button>
            </div>
        </div>

        <form method="GET" action="{{ route('loan.reports') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <select name="bank_id" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">All Banks</option>
                    @foreach($banksList as $bank)
                        <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                    @endforeach
                </select>
                <select name="stage" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">All Stages</option>
                    @foreach($stagesList as $stg)
                        <option value="{{ $stg->id }}" {{ request('stage') == $stg->id ? 'selected' : '' }}>{{ $stg->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="From Date">
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="To Date">
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('loan.reports') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Reset</a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Apply Filters</button>
            </div>
        </form>
    </div>

    <!-- Main Data Area -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-md font-bold text-gray-900">Generated Report Preview</h3>
            <span class="text-xs text-gray-500 font-medium">Updated just now</span>
        </div>

        <!-- Tab Content 1: Detailed List View -->
        <div id="content-list" class="report-tab-content block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold"># ID</th>
                        <th class="px-6 py-4 font-semibold">Project / Unit</th>
                        <th class="px-6 py-4 font-semibold">Customer Name</th>
                        <th class="px-6 py-4 font-semibold">Bank</th>
                        <th class="px-6 py-4 font-semibold">Loan Amount</th>
                        <th class="px-6 py-4 font-semibold">Current Stage</th>
                        <th class="px-6 py-4 font-semibold">Assigned To</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $loan->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $loan->unit_name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $loan->booking->booking_id ?? 'No Booking ID' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $loan->customer_name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $loan->bank->name ?? '-' }}</td>
                            <td class="px-6 py-4 font-medium text-green-600">₹ {{ number_format($loan->loan_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $loan->stage->name ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $loan->employee_name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No loan records found for the applied filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-gray-100">
                {{ $loans->links() }}
            </div>
        </div>

        <!-- Tab Content 2: Project Wise -->
        <div id="content-project" class="report-tab-content hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Project / Unit Name</th>
                        <th class="px-6 py-4 font-semibold">Total Cases</th>
                        <th class="px-6 py-4 font-semibold">Total Loan Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projectWise as $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $data->project_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $data->total_cases }} Cases</td>
                            <td class="px-6 py-4 font-medium text-blue-600">₹ {{ number_format($data->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">No project grouping data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tab Content 3: Bank Wise -->
        <div id="content-bank" class="report-tab-content hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Bank Name</th>
                        <th class="px-6 py-4 font-semibold">Total Cases</th>
                        <th class="px-6 py-4 font-semibold">Total Disbursed / Processing Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bankWise as $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $data->bank_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $data->total_cases }} Cases</td>
                            <td class="px-6 py-4 font-medium text-green-600">₹ {{ number_format($data->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">No bank grouping data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tab Content 4: Customer Wise -->
        <div id="content-customer" class="report-tab-content hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Customer Name</th>
                        <th class="px-6 py-4 font-semibold">Total Bookings / Cases</th>
                        <th class="px-6 py-4 font-semibold">Total Loan Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customerWise as $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mr-3">
                                        {{ strtoupper(substr($data->customer_name, 0, 1)) }}
                                    </div>
                                    {{ $data->customer_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $data->total_cases }} Cases</td>
                            <td class="px-6 py-4 font-medium text-purple-600">₹ {{ number_format($data->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">No customer grouping data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.report-tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        // Show target content
        document.getElementById('content-' + tabId).classList.remove('hidden');
        document.getElementById('content-' + tabId).classList.add('block');

        // Reset all buttons
        document.querySelectorAll('.report-tab-btn').forEach(btn => {
            btn.classList.remove('bg-gray-900', 'text-white', 'shadow-sm');
            btn.classList.add('bg-transparent', 'text-gray-600');
        });

        // Active styling for clicked button
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.remove('bg-transparent', 'text-gray-600');
        activeBtn.classList.add('bg-gray-900', 'text-white', 'shadow-sm');
    }
</script>
@endsection