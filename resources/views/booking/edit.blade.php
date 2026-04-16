@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Edit Booking</h2>

        {{-- Display ALL Validation Errors at the top --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4" role="alert">
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
            <div class="bg-green-50 border border-green-200 rounded-lg text-green-700 px-4 py-3 mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.update', $booking->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-6">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                        <select name="customer_id" id="customer_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('customer_id') border-red-500 @enderror">
                            <option value="">Select Customer</option>
                            @forelse($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @empty
                                <option disabled>No customers found</option>
                            @endforelse
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred By Channel Partner</label>
                        <select name="referred_by" id="referred_by" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('referred_by') border-red-500 @enderror">
                            <option value="">Select Channel Partner</option>
                            @forelse($channelPartners as $partner)
                                <option value="{{ $partner->id }}" {{ old('referred_by', $booking->referred_by) == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->partner_name }}
                                </option>
                            @empty
                                <option disabled>No channel partners found</option>
                            @endforelse
                        </select>
                        @error('referred_by')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                        <select name="project_id" id="project_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
                            <option value="">Select Project</option>
                            @forelse($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $booking->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @empty
                                <option disabled>No projects found</option>
                            @endforelse
                        </select>
                        @error('project_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hidden Unit Name Field --}}
                    <input type="hidden" name="unit_name" id="unit_name" value="{{ old('unit_name', $booking->unit_name) }}">

                    {{-- Selected Unit Display (Read-only visual feedback) --}}
                    <div id="selected-unit-display" class="bg-blue-50 border border-blue-200 rounded-lg p-4" style="display: none;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Selected Unit</p>
                                <p class="text-lg font-bold text-gray-900" id="selected-unit-name">-</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Size</p>
                                <p class="text-lg font-bold text-gray-900" id="selected-unit-size">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    {{-- Hidden Unit Size Fields --}}
                    <input type="hidden" name="unit_size" id="unit_size_input" value="{{ old('unit_size', $booking->unit_size) }}">
                    <input type="hidden" name="unit_unit" id="unit_unit_select" value="{{ old('unit_unit', $booking->unit_unit) }}">

                    <div>
                        <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Booking Date</label>
                        <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', $booking->booking_date) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('booking_date') border-red-500 @enderror"
                            required>
                        @error('booking_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="followup_date" class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                        <input type="date" name="followup_date" id="followup_date" value="{{ old('followup_date', $booking->followup_date) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('followup_date') border-red-500 @enderror"
                            required>
                        @error('followup_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Units Display Section --}}
            <div id="units-container" style="display:none;" class="mt-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">Available Units</h3>
                    <p class="text-sm text-gray-500">Click on an available unit to select</p>
                </div>
                <div id="units-output" class="bg-gray-50 rounded-lg p-4">
                    <!-- Units will be loaded here -->
                </div>
            </div>

            {{-- Financial Details --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-200">
                <div>
                    <label for="invoice_amount" class="block text-sm font-medium text-gray-700 mb-1">Invoice Amount</label>
                    <input type="number" name="invoice_amount" id="invoice_amount" value="{{ old('invoice_amount', $booking->invoice_amount) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('invoice_amount') border-red-500 @enderror"
                        required>
                    @error('invoice_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="other_amount" class="block text-sm font-medium text-gray-700 mb-1">Other Amount</label>
                    <input type="number" name="other_amount" id="other_amount" value="{{ old('other_amount', $booking->other_amount) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('other_amount') border-red-500 @enderror">
                    @error('other_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                    <input type="text" id="total_amount" name="total_amount" value="{{ old('total_amount', $booking->total_amount) }}" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="Booked" {{ old('status', $booking->status) == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            @error('unit_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('unit_size')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('unit_unit')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <div class="pt-4">
                <button type="submit" id="submit-btn"
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-8 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Update Booking
                </button>
                <a href="{{ route('bookings.list') }}"
                    class="ml-3 text-gray-600 hover:text-gray-800 font-medium py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const projectSelect = document.getElementById('project_id');
        const unitsContainer = document.getElementById('units-container');
        const unitsOutput = document.getElementById('units-output');
        const unitNameInput = document.getElementById('unit_name');
        const unitSizeInput = document.getElementById('unit_size_input');
        const unitUnitSelect = document.getElementById('unit_unit_select');
        const selectedUnitDisplay = document.getElementById('selected-unit-display');
        const selectedUnitName = document.getElementById('selected-unit-name');
        const selectedUnitSize = document.getElementById('selected-unit-size');
        const submitBtn = document.getElementById('submit-btn');
        const invoiceInput = document.getElementById('invoice_amount');
        const otherInput = document.getElementById('other_amount');
        const totalInput = document.getElementById('total_amount');

        // Store current booking unit for comparison
        const currentBookingUnit = '{{ str_replace(' ', '', old('unit_name', $booking->unit_name)) }}';
        const currentBookingSize = '{{ old('unit_size', $booking->unit_size) }}';
        const currentBookingUnitType = '{{ old('unit_unit', $booking->unit_unit) }}';

        function calculateTotal() {
            const invoice = parseFloat(invoiceInput.value) || 0;
            const other = parseFloat(otherInput.value) || 0;
            totalInput.value = (invoice + other).toFixed(2);
        }

        invoiceInput.addEventListener('input', calculateTotal);
        otherInput.addEventListener('input', calculateTotal);
        calculateTotal();

        function parseUnitSize(sizeString) {
            if (!sizeString) return { size: '', unit: 'Sq. Feet' };

            const match = sizeString.match(/^(\d+(?:\.\d+)?)\s*(Sq\.\s*Feet|Sq\.\s*Yard)?$/i);
            if (match) {
                return {
                    size: match[1],
                    unit: match[2] ? match[2].replace(/\s+/g, ' ') : 'Sq. Feet'
                };
            }
            return { size: '', unit: 'Sq. Feet' };
        }

        function updateSelectedUnitDisplay(unit, sizeString) {
            if (unit) {
                selectedUnitName.textContent = unit;
                selectedUnitSize.textContent = sizeString;
                selectedUnitDisplay.style.display = 'block';
                submitBtn.disabled = false;
            } else {
                selectedUnitDisplay.style.display = 'none';
                submitBtn.disabled = true;
            }
        }

        // Initialize display with current booking data
        if (unitNameInput.value) {
            const sizeValue = unitSizeInput.value;
            const unitValue = unitUnitSelect.value;
            const displaySize = sizeValue ? `${sizeValue} ${unitValue}` : '-';
            updateSelectedUnitDisplay(unitNameInput.value, displaySize);
        } else {
            submitBtn.disabled = true;
        }

        // Load units when project is selected/changed
        projectSelect.addEventListener('change', function () {
            const projectId = this.value;

            unitNameInput.value = '';
            unitSizeInput.value = '';
            unitUnitSelect.value = 'Sq. Feet';
            updateSelectedUnitDisplay(null, null);

            if (!projectId) {
                unitsContainer.style.display = 'none';
                unitsOutput.innerHTML = '';
                return;
            }

            unitsContainer.style.display = 'block';
            unitsOutput.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div><p class="mt-2 text-gray-600">Loading units...</p></div>';

            fetch(`/api/projects/${projectId}/units`)
                .then(res => res.json())
                .then(data => {
                    console.log("📦 API DATA:", data);

                    if (!data.units || data.units.length === 0) {
                        unitsOutput.innerHTML = '<p class="text-center text-gray-500 py-8">No units found for this project</p>';
                        return;
                    }

                    const bookedUnits = data.booked_units || [];
                    const unitSizes = data.unit_sizes || {};

                    let html = '<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3">';

                    data.units.forEach(unit => {
                        const size = unitSizes[unit] || 'N/A';
                        const unitWithoutSpace = unit.replace(/\s/g, '');
                        // Unit is booked if it's in bookedUnits AND it's not the current booking's unit
                        const isBooked = bookedUnits.includes(unit) && unitWithoutSpace !== currentBookingUnit;

                        html += `
                        <div class="unit-card ${isBooked ? 'booked' : 'available'}" 
                             data-unit="${unit}" 
                             data-size="${size}"
                             style="
                                border: 2px solid ${isBooked ? '#fca5a5' : '#86efac'};
                                padding: 12px;
                                border-radius: 8px;
                                text-align: center;
                                background: ${isBooked ? '#fee2e2' : '#dcfce7'};
                                cursor: ${isBooked ? 'not-allowed' : 'pointer'};
                                opacity: ${isBooked ? '0.6' : '1'};
                                transition: all 0.2s ease;
                             "
                             ${isBooked ? '' : 'onclick="selectUnit(this)"'}>
                            <div class="font-bold text-gray-800">${unit}</div>
                            <div class="text-xs text-gray-600 mt-1">${size}</div>
                            <div class="text-xs mt-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium ${isBooked ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800'}">
                                    ${isBooked ? 'Booked' : 'Available'}
                                </span>
                            </div>
                        </div>
                    `;
                    });

                    html += '</div>';

                    html += `
                    <div class="flex gap-4 mt-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-200 border-2 border-green-400 rounded mr-2"></div>
                            <span class="text-gray-600">Available (Click to select)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-200 border-2 border-red-400 rounded mr-2"></div>
                            <span class="text-gray-600">Booked (Unavailable)</span>
                        </div>
                    </div>
                `;

                    unitsOutput.innerHTML = html;

                    // Highlight the currently selected unit if it exists
                    const currentUnitName = unitNameInput.value;
                    if (currentUnitName) {
                        setTimeout(() => {
                            const unitCard = document.querySelector(`[data-unit="${currentUnitName}"]`);
                            if (unitCard && !unitCard.classList.contains('booked')) {
                                selectUnit(unitCard);
                            }
                        }, 100);
                    }
                })
                .catch(err => {
                    console.error("❌ API ERROR:", err);
                    unitsOutput.innerHTML = '<p class="text-center text-red-500 py-8">Error loading units. Please try again.</p>';
                });
        });

        function formatUnit(unit) {
            // A102 → A 102
            return unit.replace(/^([A-Z]+)(\d+)$/, '$1 $2');
        }

        window.selectUnit = function (element) {
            const rawUnit = element.getAttribute('data-unit');
            const formattedUnit = formatUnit(rawUnit);

            const sizeString = element.getAttribute('data-size');

            // Set correct format
            unitNameInput.value = formattedUnit;

            const { size, unit: unitType } = parseUnitSize(sizeString);
            unitSizeInput.value = size;
            unitUnitSelect.value = unitType;

            updateSelectedUnitDisplay(formattedUnit, sizeString);

            // Highlight selected unit
            document.querySelectorAll('.unit-card').forEach(card => {
                card.style.boxShadow = 'none';
                card.style.transform = 'scale(1)';
            });

            element.style.boxShadow = '0 0 0 3px #3b82f6';
            element.style.transform = 'scale(1.02)';
        };

        // Trigger initial load if project is already selected
        @if(old('project_id', $booking->project_id))
            setTimeout(() => {
                projectSelect.dispatchEvent(new Event('change'));
            }, 100);
        @endif
    });
</script>
@endpush
@endsection