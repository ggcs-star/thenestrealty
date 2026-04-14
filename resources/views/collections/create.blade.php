@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-min-screen p-4 mx-auto mt-8 p-6 bg-white shadow rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Collection Pipeline</h2>
            <a href="{{ route('collections.list') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                View All Collections
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('collections.store') }}" class="space-y-6">
            @csrf

            {{-- <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                <select name="customer_id" id="customer_id" class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                <select name="customer_id" id="customer_id" class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $collection->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <label for="booking_id" class="block text-sm font-medium text-gray-700 mb-1">Booking ID</label>
                {{-- <select name="booking_id" id="booking_id"
                    class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Booking ID</option>
                    @foreach ($BookingId as $Bookingid)
                    <option value="{{ $Bookingid->id }}">{{ $Bookingid->booking_id}}</option>
                    @endforeach
                </select> --}}

                <select name="booking_id" id="booking_id" class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm"
                    required>
                    <option value="">Select Booking ID</option>
                    @foreach ($BookingId as $booking)
                        <option value="{{ $booking->id }}">
                            {{ $booking->booking_id }} {{-- this shows TNR000X --}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <input type="hidden" name="booking_id" value="1"> --}}
            {{-- <input type="hidden" name="customer_id" value="1"> --}}
            <input type="hidden" name="partner_id" value="1">
            <input type="hidden" name="project_id" value="1">

            {{-- Payment Sections --}}
            @php
                $types = ['loan' => 'Loan', 'transfer' => 'A/C Transfer', 'other' => 'Other Mode'];
            @endphp

            @foreach($types as $key => $label)
                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount Via {{ $label }}</label>
                    <div id="{{ $key }}-container" class="flex flex-col gap-3">
                        <div class="flex gap-3">
                            <input type="date" name="{{ $key }}_dates[]" class="w-1/2 border rounded-md p-2">
                            <input type="number" name="{{ $key }}_amounts[]" class="w-1/2 border rounded-md p-2"
                                placeholder="Amount" step="0.01" min="0">
                        </div>
                    </div>
                    <!-- <button type="button" onclick="addMore('{{ $key }}')" class="mt-3 text-blue-600 border border-blue-600 hover:bg-blue-50 px-3 py-1 rounded">
                                                + Add More
                                            </button> -->
                </div>
            @endforeach

            {{-- <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</slabel>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                        <option value="Completed" {{ old('status')=='Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
            </div> --}}

            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">Select Status</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div>
                <button type="submit"
                    class="px-5 py-2 bg-[#AC7E2C] hover:bg-[#8C651F] text-white rounded-md text-base font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>

    <script>
        function addMore(type) {
            const container = document.getElementById(`${type}-container`);
            const currentCount = container.querySelectorAll('.flex').length;

            if (currentCount >= 3) {
                alert("You can only add up to 3 entries for " + type);
                return;
            }

            const newRow = document.createElement('div');
            newRow.className = 'flex gap-3';
            newRow.innerHTML = `
                        <input type="date" name="${type}_dates[]" class="w-1/2 border rounded-md p-2" required>
                        <input type="number" name="${type}_amounts[]" class="w-1/2 border rounded-md p-2" placeholder="Amount" step="0.01" min="0" required>
                    `;
            container.appendChild(newRow);
            newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    </script>
@endsection