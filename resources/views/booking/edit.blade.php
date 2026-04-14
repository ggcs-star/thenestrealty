@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-2 mx-auto mt-10">
    <div class="bg-white p-8 rounded-xl shadow-md space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Booking</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.update', $booking->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Customer --}}
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                <select name="customer_id" id="customer_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Referred By --}}
            <div>
                <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred By Channel Partner</label>
                <select name="referred_by" id="referred_by" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Channel Partner</option>
                    @foreach($channelPartners as $partner)
                        <option value="{{ $partner->id }}" {{ old('referred_by', $booking->referred_by) == $partner->id ? 'selected' : '' }}>
                            {{ $partner->partner_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Project --}}
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                <select name="project_id" id="project_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $booking->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Units Display --}}
            <div id="all-units-container" class="hidden">
                <div id="all-units" class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2 p-4 bg-gray-50 rounded-lg">
                    <!-- Units will be loaded here -->
                </div>
                <p class="text-xs text-gray-500 mt-1">Click on a green unit to select it</p>
            </div>

            {{-- Unit Name --}}
            <div>
                <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                <input type="text" name="unit_name" id="unit_name" pattern="^[A-Z][A-Z0-9]?\s\d+$"
                    value="{{ old('unit_name', $booking->unit_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Unit Size --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Size</label>
                <div class="flex gap-4">
                    <input type="number" name="unit_size" value="{{ old('unit_size', $booking->unit_size) }}"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    <select name="unit_unit" class="border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500" required>
                        <option value="Sq. Feet" {{ old('unit_unit', $booking->unit_unit) == 'Sq. Feet' ? 'selected' : '' }}>Sq. Feet</option>
                        <option value="Sq. Yard" {{ old('unit_unit', $booking->unit_unit) == 'Sq. Yard' ? 'selected' : '' }}>Sq. Yard</option>
                    </select>
                </div>
            </div>

            {{-- Dates --}}
            <div>
                <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Booking Date</label>
                <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', $booking->booking_date) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="followup_date" class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                <input type="date" name="followup_date" id="followup_date" value="{{ old('followup_date', $booking->followup_date) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Amounts --}}
            <div>
                <label for="invoice_amount" class="block text-sm font-medium text-gray-700 mb-1">Invoice Amount</label>
                <input type="number" name="invoice_amount" id="invoice" value="{{ old('invoice_amount', $booking->invoice_amount) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="other_amount" class="block text-sm font-medium text-gray-700 mb-1">Other Amount</label>
                <input type="number" name="other_amount" id="other" value="{{ old('other_amount', $booking->other_amount) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                <input type="text" id="total" name="total_amount" value="{{ old('total_amount', $booking->total_amount) }}" readonly
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="Booked" {{ old('status', $booking->status) == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit" class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Booking
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    const invoice = document.getElementById('invoice');
    const other = document.getElementById('other');
    const total = document.getElementById('total');
    const projectSelect = document.getElementById('project_id');
    const unitNameInput = document.getElementById('unit_name');
    const allUnitsContainer = document.getElementById('all-units-container');
    const allUnitsDiv = document.getElementById('all-units');
    const currentUnit = "{{ str_replace(' ', '', old('unit_name', $booking->unit_name)) }}";

    document.addEventListener('DOMContentLoaded', function () {
        updateTotal();
        if (projectSelect.value) {
            loadAllUnits(projectSelect.value);
        }
    });

    function updateTotal() {
        const a = parseFloat(invoice.value) || 0;
        const b = parseFloat(other.value) || 0;
        total.value = (a + b).toFixed(2);
    }

    invoice.addEventListener('input', updateTotal);
    other.addEventListener('input', updateTotal);

    projectSelect.addEventListener('change', function () {
        if (this.value) {
            loadAllUnits(this.value);
        } else {
            allUnitsContainer.classList.add('hidden');
        }
    });

    function loadAllUnits(projectId) {
        fetch(`/api/projects/${projectId}/units`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayAllUnits(data.units, data.booked_units);
                    allUnitsContainer.classList.remove('hidden');
                } else {
                    allUnitsContainer.classList.add('hidden');
                }
            })
            .catch(() => allUnitsContainer.classList.add('hidden'));
    }

    function displayAllUnits(units, bookedUnits) {
        allUnitsDiv.innerHTML = '';
        if (!units || units.length === 0) {
            allUnitsDiv.innerHTML = '<p class="text-gray-500 text-sm">No units found</p>';
            return;
        }
        units.forEach(unit => {
            const isBooked = bookedUnits && bookedUnits.includes(unit);
            const unitElement = document.createElement('div');
            unitElement.className = 'p-2 rounded text-center text-sm font-medium cursor-pointer transition-colors ' +
                (isBooked
                    ? 'bg-red-100 border border-red-300 text-red-700 cursor-not-allowed line-through'
                    : 'bg-green-100 border border-green-300 text-green-700 hover:bg-green-200');
            unitElement.textContent = unit;
            if (currentUnit === unit.replace(/\s/g, '')) {
                unitElement.classList.add('ring-2', 'ring-blue-500');
            }
            if (!isBooked || currentUnit === unit.replace(/\s/g, '')) {
                unitElement.onclick = function () {
                    let formattedUnit = unit;
                    if (unit.match(/^[A-Z][A-Z0-9]\d+$/)) {
                        formattedUnit = unit.replace(/([A-Z][A-Z0-9])(\d+)/, '$1 $2');
                    }
                    unitNameInput.value = formattedUnit;
                    document.querySelectorAll('#all-units > div').forEach(el => {
                        el.classList.remove('ring-2', 'ring-blue-500');
                    });
                    this.classList.add('ring-2', 'ring-blue-500');
                };
            }
            allUnitsDiv.appendChild(unitElement);
        });
    }
</script>
@endsection
