@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="flex-1 pt-10 pb-6 px-4 sm:px-6 min-h-screen bg-gray-50">
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
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
        <div class="text-sm font-medium text-yellow-700 mb-2 flex justify-between items-center">
            Total Loan Cases
            <span class="p-1.5 bg-yellow-100 rounded-md border border-yellow-200">
                <svg class="w-4 h-4 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-yellow-900">{{ number_format($totalLoans) }}</div>
        <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
            ↑ Active Pipeline Volume
        </div>
    </div>

    <!-- Open Pipeline -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
        <div class="text-sm font-medium text-green-700 mb-2 flex justify-between items-center">
            Open Pipeline
            <span class="p-1.5 bg-green-100 rounded-md border border-green-200">
                <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-green-900">₹ {{ number_format($totalAmount, 2) }}</div>
        <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
            ↑ Across active stages
        </div>
    </div>

    <!-- Dynamic Stages -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
        <div class="text-sm font-medium text-blue-700 mb-2 flex justify-between items-center">
            Dynamic Stages
            <span class="p-1.5 bg-blue-100 rounded-md border border-blue-200">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h4v4H4zM14 6h4v4h-4zM4 16h4v4H4zM14 16h4v4h-4z"/>
                </svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-blue-900">{{ number_format($dynamicStages) }}</div>
        <div class="text-xs text-yellow-600 font-medium mt-2 flex items-center">
            Custom per project / bank
        </div>
    </div>

    <!-- Disbursed -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
        <div class="text-sm font-medium text-red-700 mb-2 flex justify-between items-center">
            Disbursed / Completed
            <span class="p-1.5 bg-red-100 rounded-md border border-red-200">
                <svg class="w-4 h-4 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-red-900">{{ number_format($disbursedCases) }}</div>
        <div class="text-xs text-green-600 font-medium mt-2 flex items-center">
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

    <button onclick="switchTab('list')" id="btn-list"
        class="report-tab-btn px-4 py-2 rounded-md text-sm font-medium transition 
        bg-[#AC7E2C] text-white shadow-sm hover:bg-[#94691F]">
        Detailed List
    </button>

    <button onclick="switchTab('project')" id="btn-project"
        class="report-tab-btn px-4 py-2 rounded-md text-sm font-medium transition 
        bg-white text-gray-600 hover:bg-[#AC7E2C] hover:text-white border border-gray-200">
        Project Wise
    </button>

    <button onclick="switchTab('bank')" id="btn-bank"
        class="report-tab-btn px-4 py-2 rounded-md text-sm font-medium transition 
        bg-white text-gray-600 hover:bg-[#AC7E2C] hover:text-white border border-gray-200">
        Bank Wise
    </button>

    <button onclick="switchTab('customer')" id="btn-customer"
        class="report-tab-btn px-4 py-2 rounded-md text-sm font-medium transition 
        bg-white text-gray-600 hover:bg-[#AC7E2C] hover:text-white border border-gray-200">
        Customer Wise
    </button>

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
<button type="submit"
    class="px-4 py-2 text-sm font-medium text-white 
    bg-[#AC7E2C] rounded-lg 
    hover:bg-[#94691F] 
    active:bg-[#7A5418] 
    transition-all duration-200 shadow-sm">
    Apply Filters
</button>            </div>
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
    btn.classList.remove('bg-[#AC7E2C]', 'text-white', 'shadow-sm');
    btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
});

        // Active styling for clicked button
       
const activeBtn = document.getElementById('btn-' + tabId);
activeBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
activeBtn.classList.add('bg-[#AC7E2C]', 'text-white', 'shadow-sm');
    }
</script>
@endsection