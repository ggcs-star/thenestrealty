@php
$hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">

<!-- Header -->
<div class="flex justify-between items-center border-b pb-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">INVOICE</h2>
        <p class="text-sm text-gray-500">Commission Invoice</p>
    </div>
    <div class="text-right">
        <p class="text-sm text-gray-500">Date</p>
        <p class="font-semibold">{{ now()->format('d M Y') }}</p>
    </div>
</div>

<!-- Info -->
<div class="grid grid-cols-2 gap-6 mb-6">
    <div>
        <p class="text-sm text-gray-500">Customer</p>
        <p class="font-semibold">{{ $commission->customer->name ?? '-' }}</p>
    </div>

    <div>
        <p class="text-sm text-gray-500">Channel Partner</p>
        <p class="font-semibold">{{ $commission->partner->partner_name ?? '-' }}</p>
    </div>

    <div>
        <p class="text-sm text-gray-500">Project</p>
        <p class="font-semibold">{{ $commission->project->name ?? '-' }}</p>
    </div>

    <div>
        <p class="text-sm text-gray-500">Booking ID</p>
        <p class="font-semibold">{{ $commission->booking_id }}</p>
    </div>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border text-left">Description</th>
                <th class="px-4 py-2 border text-left">Unit</th>
                <th class="px-4 py-2 border text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2 border">Commission for Booking</td>
                <td class="px-4 py-2 border">{{ $commission->unit_name }}</td>
                <td class="px-4 py-2 border text-right">
                    ₹ {{ number_format($commission->total_amount, 2) }}
                </td>
            </tr>

            <tr>
                <td class="px-4 py-2 border">Commission Rate</td>
                <td class="px-4 py-2 border">{{ $commission->partner_commission_rate }}%</td>
                <td class="px-4 py-2 border text-right">-</td>
            </tr>

            <tr class="bg-gray-50 font-semibold">
                <td colspan="2" class="px-4 py-2 border text-right">Total Commission</td>
                <td class="px-4 py-2 border text-right text-green-600">
                    ₹ {{ number_format($commission->amount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Footer -->
<div class="mt-8 flex justify-between items-center">
    <a href="{{ route('commissions.list') }}"
       class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
        Back
    </a>

    <a href="{{ route('commissions.download', $commission->id) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Download PDF
    </a>
</div>

</div>

@endsection
