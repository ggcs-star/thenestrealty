@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="flex-1 p-4 sm:p-6 min-h-full bg-gray-50">

        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Home</a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-600 font-semibold">Dashboard</li>
            </ol>
        </nav>



        <!-- Stat Cards -->
       <div class="grid gap-5 mb-10 pt-6"
     style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">

            <!-- Total Partners -->
            <div
                class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200">
                <div class="text-3xl font-bold text-yellow-700">{{ $totalPartners }}</div>
                <div class="text-sm text-gray-600">Total Partners</div>
                <a href="{{ route('partner.list') }}">
                    <div class="mt-3 text-sm font-semibold text-yellow-700 hover:underline">
                        View Details →
                    </div>
                </a>
            </div>

            <!-- Projects -->
            <div
                class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-green-50 to-green-100 border border-green-200">
                <div class="text-3xl font-bold text-green-700">{{ $totalProject }}</div>
                <div class="text-sm text-gray-600">Projects</div>
                <a href="{{ route('projects.list') }}">
                    <div class="mt-3 text-sm font-semibold text-green-700 hover:underline">
                        View Details →
                    </div>
                </a>
            </div>

            <!-- Bookings -->
            <div
                class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200">
                <div class="text-3xl font-bold text-purple-700">{{ $totalBooking }}</div>
                <div class="text-sm text-gray-600">Bookings</div>
                <a href="{{ route('bookings.list') }}">
                    <div class="mt-3 text-sm font-semibold text-purple-700 hover:underline">
                        View Details →
                    </div>
                </a>
            </div>

            <!-- Collections -->
            <div
                class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
                <div class="text-3xl font-bold text-blue-700">{{ $totalCollection }}</div>
                <div class="text-sm text-gray-600">Collections</div>
                <a href="{{ route('collections.list') }}">
                    <div class="mt-3 text-sm font-semibold text-blue-700 hover:underline">
                        View Details →
                    </div>
                </a>
            </div>

            @if(!auth('employee')->check())
                <!-- Commission -->
                <div
                    class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
                    <div class="text-3xl font-bold text-orange-700">{{ $totalCommission }}</div>
                    <div class="text-sm text-gray-600">Commission</div>
                    <a href="{{ route('commissions.list') }}">
                        <div class="mt-3 text-sm font-semibold text-orange-700 hover:underline">
                            View Details →
                        </div>
                    </a>
                </div>

                <!-- Employees -->
                <div
                    class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-red-50 to-red-100 border border-red-200">
                    <div class="text-3xl font-bold text-red-700">{{ $totalEmployees }}</div>
                    <div class="text-sm text-gray-600">Employees</div>
                    <a href="{{ route('employees.index') }}">
                        <div class="mt-3 text-sm font-semibold text-red-700 hover:underline">
                            View Details →
                        </div>
                    </a>
                </div>
            @endif
        </div>

        <!-- Two Column Layout for Reports -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Left Column - Project Reports -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Project Reports</h2>
                </div>

                <!-- Unit Stats Cards -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                        <p class="text-xs text-gray-600 mb-1">Total Units</p>
                        <h3 class="text-2xl font-bold text-blue-700">{{ $totalUnits }}</h3>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                        <p class="text-xs text-gray-600 mb-1">Available</p>
                        <h3 class="text-2xl font-bold text-green-700">{{ $availableUnits }}</h3>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-xl border border-red-200">
                        <p class="text-xs text-gray-600 mb-1">Booked</p>
                        <h3 class="text-2xl font-bold text-red-700">{{ $bookedUnits }}</h3>
                    </div>
                </div>

                <!-- Tabs for Unit Reports -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="flex border-b bg-gray-50">
                        <button onclick="showProjectTab('available')" id="tab-available"
                            class="project-tab px-4 py-3 text-sm font-medium border-b-2 border-blue-500 text-blue-600 bg-white">
                            Available Units
                        </button>
                        <button onclick="showProjectTab('booking')" id="tab-booking"
                            class="project-tab px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                            Booked Units
                        </button>
                        <button onclick="showProjectTab('cancel')" id="tab-cancel"
                            class="project-tab px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                            Cancelled Units
                        </button>
                    </div>

                    <!-- Available Units Tab -->
                    <div id="project-available" class="project-tab-content p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Unit
                                            No</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Tower
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Size
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($availableUnitsTable as $unit)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-3 font-medium text-gray-900">{{ $unit['unit_no'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['tower'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['size'] }}</td>

                                            <td class="py-3 px-3">
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                                    Available
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-gray-500">
                                                No available units found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Booked Units Tab -->
                    <div id="project-booking" class="project-tab-content hidden p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Unit
                                            No</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Tower
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Size
                                        </th>
                                         <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Booking id
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Customer
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($bookedUnitsTable as $unit)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-3 font-medium text-gray-900">{{ $unit['unit_no'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['tower'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['size'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['booking_id'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $unit['customer'] }}</td>
                                            <td class="py-3 px-3">
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                                    Booked
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-gray-500">
                                                No booked units found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cancelled Units Tab -->
                  <!-- Cancelled Units Tab -->
<div id="project-cancel" class="project-tab-content hidden p-4">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Unit No</th>
                    <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Project</th>
                    <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($cancellationUnitsTable as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-3 font-medium text-gray-900">{{ $row['unit_no'] }}</td>
                        <td class="py-3 px-3 text-gray-600">{{ $row['project'] }}</td>
                        <td class="py-3 px-3 text-gray-600">{{ $row['customer'] }}</td>
                        <td class="py-3 px-3 text-gray-600">{{ $row['date'] }}</td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                {{ $row['status'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            No cancelled units found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
                </div>
            </div>

            <!-- Right Column - Customer Reports -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Customer Overview</h2>
                    {{-- <a href="{{ route('customers.list') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All Customers →</a> --}}
                </div>

                <!-- Customer Stats -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 rounded-xl border border-indigo-200">
                        <p class="text-xs text-gray-600 mb-1">Total Customers</p>
                        <h3 class="text-2xl font-bold text-indigo-700">{{ $totalCustomers ?? 0 }}</h3>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                        <p class="text-xs text-gray-600 mb-1">Total Bookings</p>
                        <h3 class="text-2xl font-bold text-green-700">{{ $totalCustomerBookings ?? 0 }}</h3>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                        <p class="text-xs text-gray-600 mb-1">Total Payments</p>
                        <h3 class="text-2xl font-bold text-blue-700">₹ {{ amountToPoints($totalCustomerPayments ?? 0) }}</h3>
                    </div>
                </div>

                <!-- Customer Tabs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="flex border-b bg-gray-50">
                        <button onclick="showCustomerTab('bookingReport')" id="customer-tab-booking"
                            class="customer-tab px-4 py-3 text-sm font-medium border-b-2 border-blue-500 text-blue-600 bg-white">
                            Booking Report
                        </button>
                        <button onclick="showCustomerTab('paymentReport')" id="customer-tab-payment"
                            class="customer-tab px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                            Payment Report
                        </button>
                        <button onclick="showCustomerTab('receivableReport')" id="customer-tab-receivable"
                            class="customer-tab px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                            Receivable Report
                        </button>
                    </div>

                    <!-- Booking Report -->
                    <div id="customer-bookingReport" class="customer-tab-content p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">
                                            Customer</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">
                                            Booking ID</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Unit
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($bookingReport ?? [] as $row)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-3 text-gray-900">{{ $row['customer'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $row['booking_id'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $row['unit'] }}</td>
                                            <td class="py-3 px-3 font-medium text-gray-900">₹
                                                {{ amountToPoints($row['amount']) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-500">
                                                No booking data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Report -->
                    <div id="customer-paymentReport" class="customer-tab-content hidden p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">
                                            Customer</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Amount
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($paymentReport ?? [] as $row)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-3 text-gray-900">{{ $row['customer'] }}</td>
                                            <td class="py-3 px-3 font-medium text-green-600">₹
                                                {{ amountToPoints($row['amount']) }}</td>
                                            <td class="py-3 px-3 text-gray-600">{{ $row['date'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center text-gray-500">
                                                No payment data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Receivable Report -->
                    <div id="customer-receivableReport" class="customer-tab-content hidden p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">
                                            Customer</th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Total
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Paid
                                        </th>
                                        <th class="text-left py-3 px-3 text-xs font-semibold text-gray-600 uppercase">Due
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($receivableReport ?? [] as $row)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-3 text-gray-900">{{ $row['customer'] }}</td>
                                            <td class="py-3 px-3 text-gray-600">₹ {{ amountToPoints($row['total']) }}</td>
                                            <td class="py-3 px-3 text-green-600">₹ {{ amountToPoints($row['paid']) }}</td>
                                            <td class="py-3 px-3 text-red-600 font-medium">₹ {{ amountToPoints($row['due']) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-500">
                                                No receivable data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Followup Section -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Collection Followups</h2>
                <a href="{{ route('collections.list') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View
                    All Followups →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Today's Follow-ups -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Today's Follow-ups</h3>
                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">Due Today</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($todayFollowUps as $item)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ ucfirst($item->mode) }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Amount: ₹{{ amountToPoints($item->amount) }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Booking: {{ $item->booking->booking_id ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">No follow-ups today</p>
                        @endforelse
                    </div>
                </div>

                <!-- Backlog Follow-ups -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Backlog Follow-ups</h3>
                        <span
                            class="bg-yellow-100 text-yellow-700 text-xs font-medium px-2 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($historyFollowUps as $item)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ ucfirst($item->mode) }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Amount: ₹{{ amountToPoints($item->amount) }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($item->date)->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">No backlog follow-ups</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Follow-ups -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Upcoming Follow-ups</h3>
                        <span
                            class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Scheduled</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentFollowUps as $item)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ ucfirst($item->mode) }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Date: {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            ₹{{ amountToPoints($item->amount) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">No upcoming follow-ups</p>
                        @endforelse
                    </div>
                </div>

                <!-- Complete Follow-ups -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Completed Follow-ups</h3>
                        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded-full">Done</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($completeFollowUps as $item)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ ucfirst($item->mode) }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Date: {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            ₹{{ amountToPoints($item->amount) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">No completed follow-ups</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showProjectTab(tab) {
            document.querySelectorAll('.project-tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('project-' + tab).classList.remove('hidden');

            document.querySelectorAll('.project-tab').forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'bg-white');
                btn.classList.add('text-gray-600');
            });
            document.getElementById('tab-' + tab).classList.add('border-blue-500', 'text-blue-600', 'bg-white');
        }

        function showCustomerTab(tab) {
            document.querySelectorAll('.customer-tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('customer-' + tab).classList.remove('hidden');

            document.querySelectorAll('.customer-tab').forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'bg-white');
                btn.classList.add('text-gray-600');
            });
            document.getElementById('customer-tab-' + tab).classList.add('border-blue-500', 'text-blue-600', 'bg-white');
        }

        document.addEventListener('DOMContentLoaded', function () {
            showProjectTab('available');
            showCustomerTab('bookingReport');
        });
    </script>
@endsection