@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="w-min-screen p-2 mx-auto mt-10">
        <div class="bg-white p-8 rounded-xl shadow-md space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Create Booking</h2>

            {{-- Display ALL Validation Errors at the top --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
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
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                    <select name="customer_id" id="customer_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('customer_id') border-red-500 @enderror">
                        <option value="">Select Customer</option>
                        @forelse($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @empty
                            <option disabled>No customers found</option>
                        @endforelse
                    </select>
                    @error('customer_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(isset($customers) && is_countable($customers))
                        <p class="text-sm text-gray-500 mt-1">Customers count: {{ count($customers) }}</p>
                    @endif
                </div>

                <div>
                    <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred By Channel
                        Partner</label>
                    <select name="referred_by" id="referred_by" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('referred_by') border-red-500 @enderror">
                        <option value="">Select Channel Partner</option>
                        @forelse($channelPartners as $partner)
                            <option value="{{ $partner->id }}" {{ old('referred_by') == $partner->id ? 'selected' : '' }}>
                                {{ $partner->partner_name }} {{-- CHANGED: Use partner_name from your 'partners' table --}}
                            </option>
                        @empty
                            <option disabled>No channel partners found</option>
                        @endforelse
                    </select>
                    @error('referred_by')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(isset($channelPartners) && is_countable($channelPartners))
                        <p class="text-sm text-gray-500 mt-1">Channel Partners count: {{ count($channelPartners) }}</p>
                    @endif
                </div>

                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                    <select name="project_id" id="project_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
                        <option value="">Select Project</option>
                        @forelse($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @empty
                            <option disabled>No projects found</option>
                        @endforelse
                    </select>
                    @error('project_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if(isset($projects) && is_countable($projects))
                        <p class="text-sm text-gray-500 mt-1">Projects count: {{ count($projects) }}</p>
                    @endif
                </div>

                <!-- All Units Display -->
                <div id="all-units-container" class="hidden">
                    <!-- <label class="block text-sm font-medium text-gray-700 mb-1">Units (Green = Available, Red = Booked)</label> -->
                    <div id="all-units"
                        class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2 p-4 bg-gray-50 rounded-lg">
                        <!-- Units will be loaded here -->
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Click on a green unit to select it</p>
                </div>

                <div>
                    <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                    <input type="text" name="unit_name" id="unit_name" pattern="^[A-Z][A-Z0-9]?\s\d+$"
                        placeholder="Eg: A 101" value="{{ old('unit_name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('unit_name') border-red-500 @enderror"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Format: First letter capital, optional second letter or digit,
                        space, then number</p>
                    @error('unit_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Size</label>
                    <div class="flex gap-4">
                        <input type="number" name="unit_size" value="{{ old('unit_size') }}"
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('unit_size') border-red-500 @enderror"
                            required>
                        <select name="unit_unit"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('unit_unit') border-red-500 @enderror"
                            required>
                            <option value="Sq. Feet" {{ old('unit_unit') == 'Sq. Feet' ? 'selected' : '' }}>Sq. Feet</option>
                            <option value="Sq. Yard" {{ old('unit_unit') == 'Sq. Yard' ? 'selected' : '' }}>Sq. Yard</option>
                        </select>
                    </div>
                    @error('unit_size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('unit_unit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Booking Date</label>
                    <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('booking_date') border-red-500 @enderror"
                        required>
                    @error('booking_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="followup_date" class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                    <input type="date" name="followup_date" id="followup_date" value="{{ old('followup_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('followup_date') border-red-500 @enderror"
                        required>
                    @error('followup_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="invoice" class="block text-sm font-medium text-gray-700 mb-1">Invoice Amount</label>
                    <input type="number" name="invoice_amount" id="invoice" value="{{ old('invoice_amount') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('invoice_amount') border-red-500 @enderror"
                        required>
                    @error('invoice_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="other" class="block text-sm font-medium text-gray-700 mb-1">Other Amount</label>
                    <input type="number" name="other_amount" id="other" value="{{ old('other_amount', 0) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('other_amount') border-red-500 @enderror">
                    @error('other_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                    <input type="text" id="total" name="total_amount" value="{{ old('total_amount') }}" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</slabel>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="Booked" {{ old('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        Create Booking
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
        
        // Calculate total when either input changes
        invoice.addEventListener('input', updateTotal);
        other.addEventListener('input', updateTotal);
        
        // Also calculate when values are changed programmatically
        invoice.addEventListener('change', updateTotal);
        other.addEventListener('change', updateTotal);

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
                .catch(error => {
                    console.error('Error loading units:', error);
                    allUnitsContainer.classList.add('hidden');
                });
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
                if (!isBooked) {
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