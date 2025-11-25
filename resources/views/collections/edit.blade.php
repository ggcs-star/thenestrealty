@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen mx-auto mt-10">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Collection</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-3 rounded-lg mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('collections.update', $collection->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <!-- Customer -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                <select name="customer_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id', $collection->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Booking -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Booking</label>
                <select name="booking_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    @foreach($BookingId as $booking)
                        <option value="{{ $booking->id }}"
                            {{ old('booking_id', $collection->booking_id) == $booking->id ? 'selected' : '' }}>
                            {{ $booking->booking_id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Project ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Project ID</label>
                <input type="number" name="project_id" value="{{ old('project_id', $collection->project_id) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- Partner ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Partner ID</label>
                <input type="number" name="partner_id" value="{{ old('partner_id', $collection->partner_id) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" value="{{ old('date', $collection->date) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- Amount -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                <input type="number" name="amount" step="0.01" value="{{ old('amount', $collection->amount) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- Mode -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mode</label>
                <select name="mode"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    @foreach(['Loan', 'Transfer', 'Other'] as $mode)
                        <option value="{{ $mode }}" {{ old('mode', $collection->mode) === $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="Pending" {{ old('status', $collection->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ old('status', $collection->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="col-span-1 md:col-span-2 pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Collection
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
