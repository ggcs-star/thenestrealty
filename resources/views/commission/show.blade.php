@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoiceArea,
            #invoiceArea * {
                visibility: visible;
            }

            #invoiceArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <div id="invoiceArea" class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-10">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Commission Invoice</h2>
                <p class="text-sm text-gray-500">Invoice ID: #{{ $commission->id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Date</p>
                <p class="font-semibold">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mb-6 flex justify-end">
            <div class="inline-flex items-center gap-2">
                <span class="text-sm font-medium text-gray-600">Payment Status:</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $commission->payment_status === 'confirmed'
        ? 'bg-green-100 text-green-700 border border-green-300'
        : 'bg-yellow-100 text-yellow-700 border border-yellow-300' }}">
                    {{ ucfirst($commission->payment_status ?? 'Pending') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-500">Booking ID</p>
                <p class="font-semibold">{{ $commission->booking_id ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Customer Name</p>
                <p class="font-semibold">{{ $commission->customer->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Project Name</p>
                <p class="font-semibold">{{ $commission->project->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Channel Partner</p>
                <p class="font-semibold">{{ $commission->partner->partner_name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Unit Name</p>
                <p class="font-semibold">{{ $commission->unit_name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Commission Rate</p>
                <p class="font-semibold">{{ $commission->partner_commission_rate ?? '-' }}</p>
            </div>
        </div>

        <table class="w-full border text-sm mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">Description</th>
                    <th class="px-4 py-2 border text-left">Details</th>
                    <th class="px-4 py-2 border text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border">Total Booking Amount</td>
                    <td class="px-4 py-2 border">{{ $commission->unit_name }}</td>
                    <td class="px-4 py-2 border text-right">₹ {{ amountToPoints($commission->total_amount) }}</td>
                </tr>

                <tr>
                    <td class="px-4 py-2 border">Commission Calculation</td>
                    <td class="px-4 py-2 border">{{ $commission->partner_commission_rate }} of total amount</td>
                    <td class="px-4 py-2 border text-right">₹ {{ amountToPoints($commission->amount) }}</td>
                </tr>

                <tr class="bg-gray-50 font-semibold">
                    <td colspan="2" class="px-4 py-2 border text-right">Total Commission Payable</td>
                    <td class="px-4 py-2 border text-right text-green-600 font-bold">
                        ₹ {{ amountToPoints($commission->amount) }}
                    </td>
                </tr>
            </tbody>
        </table>


        <div class="flex justify-between mt-6 no-print">
            <a href="{{ route('commissions.list') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                ← Back to List
            </a>

            <button onclick="window.print()"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                View / Print Invoice
            </button>
        </div>
    </div>
@endsection