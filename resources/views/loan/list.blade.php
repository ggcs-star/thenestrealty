@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Loan Records</h2>
        <p class="text-sm text-gray-500">Manage and track all loan entries</p>
    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">

        @if($loans->isEmpty())
            <div class="p-8 text-center text-gray-500">
                No loan records found
            </div>
        @else

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Booking ID</th>
                        <th class="px-4 py-3 text-left">Unit</th>
                        <th class="px-4 py-3 text-left">Bank</th>
                        <th class="px-4 py-3 text-left">Employee</th>
                        <th class="px-4 py-3 text-left">Amount</th>
                        <th class="px-4 py-3 text-left">Stage</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                    @foreach ($loans as $index => $loan)
                    <tr class="hover:bg-gray-50 transition">

                        <!-- INDEX -->
                        <td class="px-4 py-3 text-gray-500">
                            {{ $loans->firstItem() + $index }}
                        </td>

                        <!-- CUSTOMER -->
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $loan->customer_name }}
                        </td>

                        <!-- BOOKING -->
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loan->booking_id }}
                        </td>

                        <!-- UNIT -->
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loan->unit_name }}
                        </td>

                        <!-- BANK -->
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loan->bank_name }}
                        </td>

                        <!-- EMPLOYEE -->
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loan->employee_name }}
                        </td>

                        <!-- AMOUNT -->
                        <td class="px-4 py-3 text-green-600 font-semibold">
                            {{ amountToPoints($loan->loan_amount) }}
                        </td>

                        <!-- STAGE -->
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $loan->loan_stage === 'Approved' ? 'bg-green-100 text-green-700' :
                                   ($loan->loan_stage === 'Pending' ? 'bg-yellow-100 text-yellow-700' :
                                   'bg-red-100 text-red-700') }}">
                                {{ $loan->loan_stage }}
                            </span>
                        </td>

                        <!-- ACTION -->
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="inline-flex items-center px-3 py-1.5 text-xs bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F] transition">
                                Edit
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        @endif

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $loans->withQueryString()->links() }}
    </div>

</section>
@endsection