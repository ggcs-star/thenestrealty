@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-min-screen p-10 mx-auto mt-10 p-6 bg-white shadow rounded">
        <!-- Header and Filter Button -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                @if(request('date'))
                    Filtered Follow-ups ({{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }})
                @elseif(request('from') && request('to'))
                    Filtered Follow-ups ({{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }})
                @elseif(request('from'))
                    Filtered Follow-ups (From {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }})
                @elseif(request('to'))
                    Filtered Follow-ups (Until {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }})
                @else
                    All Follow-ups
                @endif
            </h2>

            <!-- Date Filter Form -->
            <form method="GET" action="{{ route('collections.list') }}" class="flex gap-2 items-center">
                <label for="from" class="text-sm font-medium text-gray-700">From:</label>
                <input type="date" id="from" name="from"
                    value="{{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('Y-m-d') : '' }}"
                    class="border border-gray-300 px-3 py-1 rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <label for="to" class="text-sm font-medium text-gray-700">To:</label>
                <input type="date" id="to" name="to"
                    value="{{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('Y-m-d') : '' }}"
                    class="border border-gray-300 px-3 py-1 rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Apply</button>

                @if(request('date') || request('from') || request('to'))
                    <a href="{{ route('collections.list') }}"
                        class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 ml-2">Clear</a>
                @endif
            </form>
        </div>

        <!-- Commitments Table -->
        <table class="w-full table-auto border text-sm text-center">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="px-3 py-2 border">Mode</th>
                    <th class="px-3 py-2 border">Date</th>
                    <th class="px-3 py-2 border">Amount</th>
                    <th class="px-3 py-2 border">Customer Name</th>
                    <th class="px-3 py-2 border">Booking Id</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collections as $collection)
                    <tr>
                        <td class="px-3 py-2 border">{{ $collection->mode }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($collection->date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 border font-semibold text-blue-800">
                            {{ amountToPoints($collection->amount) }}
                        </td>
                        <td class="px-3 py-2 border">{{ $collection->customer->name ?? 'N/A' }}</td>
                        <td class="px-3 py-2 border">{{ $collection->booking->booking_id ?? 'N/A' }}</td>
                        <td class="px-3 py-2 border">
                            <span
                                class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                                                            {{ $collection->status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($collection->status) }}
                            </span>
                        </td>


                        <td class="px-3 py-2 border text-center">
                            <a href="{{ route('collections.edit', $collection->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                Edit
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-4 text-center">No commitments yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const inrFormatter = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2
                });

                document.querySelectorAll('.inr-amount').forEach(function (el) {
                    const amount = parseFloat(el.dataset.amount);
                    if (!isNaN(amount)) {
                        el.textContent = inrFormatter.format(amount); // e.g. ₹12,34,567.89
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const fromInput = document.getElementById('from');
                const toInput = document.getElementById('to');

                toInput.addEventListener('change', function () {
                    if (fromInput.value && toInput.value && fromInput.value > toInput.value) {
                        alert('End date must be after start date');
                        toInput.value = '';
                    }
                });

                fromInput.addEventListener('change', function () {
                    if (fromInput.value && toInput.value && fromInput.value > toInput.value) {
                        alert('Start date must be before end date');
                        fromInput.value = '';
                    }
                });
            });
        </script>
    @endpush
@endsection