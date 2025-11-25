@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen mx-auto mt-10">
    <div class="bg-white p-8 rounded-2xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Loan Records</h2>
        

        @if($loans->isEmpty())
            <p class="text-gray-600 text-sm">No loan records found.</p>
        @else
            <div class="overflow-x-auto border-1">
                <table class="min-w-full table-auto text-sm text-gray-800">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Customer Name</th>
                            <th class="px-4 py-2 border">Booking ID</th>
                            <th class="px-4 py-2 border">Unit Name</th>
                            <th class="px-4 py-2 border">Bank Name</th>
                            <th class="px-4 py-2 border">Employee Name</th>
                            <th class="px-4 py-2 border">Loan Amount</th>
                            <th class="px-4 py-2 border">Loan Stage</th>
                            <th class="px-4 py-2 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($loans as $index => $loan)
                        <tr class="hover:bg-gray-50 transition text-center">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $loan->customer_name }}</td>
                           <td class="px-4 py-2 border">{{ $loan->booking_id }}</td>
                            <td class="px-4 py-2 border">{{ $loan->unit_name }}</td>
                            <td class="px-4 py-2 border">{{ $loan->bank_name }}</td>
                            <td class="px-4 py-2 border">{{ $loan->employee_name }}</td>
                            <td class="px-4 py-2 border text-green-700">{{ amountToPoints($loan->loan_amount) }}</td>
                            <td class="px-4 py-2 border">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $loan->loan_stage === 'Approved' ? 'bg-green-100 text-green-800' :
                                       ($loan->loan_stage === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-gray-100 text-gray-800') }}">
                                    {{ $loan->loan_stage }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a href="#"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1 rounded transition">
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
</section>
@endsection
