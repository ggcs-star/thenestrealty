@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
    <!-- HEADER -->
 

    <!-- ALERTS -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 md:p-6">

    <!-- HEADER INSIDE CARD -->
    <div class="flex justify-between items-start mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Collection Pipeline</h2>
            <p class="text-xs text-gray-500">Manage payment collections</p>
        </div>

        <a href="{{ route('collections.list') }}"
            class="px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100">
            View All
        </a>
    </div>
        <form method="POST" action="{{ route('collections.store') }}">
            @csrf

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- CUSTOMER -->
                <div>
                    <label class="text-sm text-gray-600">Customer</label>
                    <select name="customer_id"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- BOOKING -->
                <div>
                    <label class="text-sm text-gray-600">Booking ID</label>
                    <select name="booking_id"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select Booking</option>
                        @foreach ($BookingId as $booking)
                            <option value="{{ $booking->id }}">
                                {{ $booking->booking_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select Status</option>
                        <option value="Completed">Completed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>

            </div>

            <!-- HIDDEN -->
            <input type="hidden" name="partner_id" value="1">
            <input type="hidden" name="project_id" value="1">

            <!-- PAYMENT SECTIONS -->
            @php
                $types = ['loan' => 'Loan', 'transfer' => 'A/C Transfer', 'other' => 'Other Mode'];
            @endphp

            <div class="mt-6 space-y-4">

                @foreach($types as $key => $label)
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm font-semibold text-gray-700">
                                {{ $label }} Payments
                            </h3>

                            <button type="button"
                                onclick="addMore('{{ $key }}')"
                                class="text-xs text-[#AC7E2C] border border-[#AC7E2C] px-2 py-1 rounded hover:bg-[#AC7E2C]/10">
                                + Add
                            </button>
                        </div>

                        <div id="{{ $key }}-container" class="space-y-2">
                            <div class="flex gap-3">
                                <input type="date"
                                    name="{{ $key }}_dates[]"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">

                                <input type="number"
                                    name="{{ $key }}_amounts[]"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg"
                                    placeholder="Amount">
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F]">
                    Save Collection
                </button>
            </div>

        </form>

    </div>

</section>

<script>
function addMore(type) {
    const container = document.getElementById(`${type}-container`);
    const count = container.children.length;

    if (count >= 3) {
        alert("Max 3 entries allowed");
        return;
    }

    const row = document.createElement('div');
    row.className = 'flex gap-3';
    row.innerHTML = `
        <input type="date" name="${type}_dates[]" class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">
        <input type="number" name="${type}_amounts[]" class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg" placeholder="Amount">
    `;

    container.appendChild(row);
}
</script>

@endsection