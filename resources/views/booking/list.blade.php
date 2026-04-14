@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
    <section class="w-min-screen mx-auto mt-10">
        <div class="bg-white p-8 rounded-xl">
            <div class="flex justify-between">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Booking List</h2>
                <form method="GET" action="{{ route('bookings.list') }}" class="flex gap-2 items-center">
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
                        <a href="{{ route('bookings.list') }}"
                            class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 ml-2">Clear</a>
                    @endif
                </form>
            </div>

            @if($bookings->isEmpty())
                <p class="text-gray-600 text-sm">No bookings found.</p>
            @else
                <div class="overflow-x-auto border-1">
                    <table class="min-w-full table-auto text-sm text-gray-800">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Booking ID</th>
                                <th class="px-4 py-2 border">Customer</th>
                                <th class="px-4 py-2 border">Project</th>
                                <th class="px-4 py-2 border">Referred By</th>
                                <th class="px-4 py-2 border">Unit Name</th>
                                <th class="px-4 py-2 border">Booking Date</th>
                                <th class="px-4 py-2 border">Invoice</th>
                                <th class="px-4 py-2 border">Other</th>
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $booking->booking_id ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $booking->customer->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $booking->project->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $booking->channelPartner->partner_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $booking->unit_name }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-2 border text-green-700">{{ amountToPoints($booking->invoice_amount) }}
                                    </td>
                                    <td class="px-4 py-2 border text-yellow-700">{{ amountToPoints($booking->other_amount) }}
                                    </td>
                                    <td class="px-4 py-2 border font-semibold text-blue-800">
                                        {{ amountToPoints($booking->total_amount) }}</td>
                                    {{-- <td class="px-4 py-2 border font-semibold rounded-full bg-green-100 text-green-700">{{
                                        $booking->status }}</td> --}}

                                    <td class="px-3 py-2 border">
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                            {{ strtolower($booking->status) === 'booked' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center gap-2 flex-wrap">
                                            <a href="{{ route('bookings.edit', $booking->id) }}"
                                                class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white text-xs font-medium px-3 py-1 rounded transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Optional pagination --}}
                {{-- <div class="mt-4">
                    {{ $bookings->links() }}
                </div> --}}
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
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