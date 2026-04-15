@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Create Booking</h2>

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

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-6">
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
                    </div>

                    <div>
                        <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred By Channel Partner</label>
                        <select name="referred_by" id="referred_by" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('referred_by') border-red-500 @enderror">
                            <option value="">Select Channel Partner</option>
                            @forelse($channelPartners as $partner)
                                <option value="{{ $partner->id }}" {{ old('referred_by') == $partner->id ? 'selected' : '' }}>
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
                        <label for="project_id3" class="block text-sm font-medium text-gray-700 mb-1">Select Project</label>
                        <select name="project_id" id="project_id3" required
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
                    </div>

                    <div>
                        <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                        <input type="text" name="unit_name" id="unit_name" 
                            placeholder="Click on a unit below or type manually" 
                            value="{{ old('unit_name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('unit_name') border-red-500 @enderror"
                            required>
                        <p class="text-xs text-gray-500 mt-1">Format: First letter capital, optional second letter or digit, space, then number</p>
                        @error('unit_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Size</label>
                        <div class="flex gap-4">
                            <input type="number" name="unit_size" id="unit_size_input" value="{{ old('unit_size') }}"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('unit_size') border-red-500 @enderror"
                                required>
                            <select name="unit_unit" id="unit_unit_select"
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
                </div>
            </div>

            {{-- Units Display Section --}}
            <div id="units-container" style="display:none;" class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Available Units</h3>
                <div id="units-output" class="bg-gray-50 rounded-lg p-4">
                    <!-- Units will be loaded here -->
                </div>
            </div>

            {{-- Financial Details --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-200">
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
            </div>

            <div class="pt-4 border-t border-gray-200">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="Booked" {{ old('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-8 rounded-lg transition duration-200">
                    Create Booking
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
    
    const projectSelect = document.getElementById('project_id3');
    const unitsContainer = document.getElementById('units-container');
    const unitsOutput = document.getElementById('units-output');
    const unitNameInput = document.getElementById('unit_name');
    const unitSizeInput = document.getElementById('unit_size_input');
    const unitUnitSelect = document.getElementById('unit_unit_select');
    const invoiceInput = document.getElementById('invoice');
    const otherInput = document.getElementById('other');
    const totalInput = document.getElementById('total');

    // Calculate total amount
    function calculateTotal() {
        const invoice = parseFloat(invoiceInput.value) || 0;
        const other = parseFloat(otherInput.value) || 0;
        totalInput.value = (invoice + other).toFixed(2);
    }

    invoiceInput.addEventListener('input', calculateTotal);
    otherInput.addEventListener('input', calculateTotal);
    calculateTotal(); // Initial calculation

    // Parse unit size string (e.g., "1200 Sq. Feet")
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

    // Load units when project is selected
    projectSelect.addEventListener('change', function () {
        const projectId = this.value;

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
                    const isBooked = bookedUnits.includes(unit);
                    
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
                
                // Add legend
                html += `
                    <div class="flex gap-4 mt-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-200 border-2 border-green-400 rounded mr-2"></div>
                            <span class="text-gray-600">Available</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-200 border-2 border-red-400 rounded mr-2"></div>
                            <span class="text-gray-600">Booked</span>
                        </div>
                    </div>
                `;
                
                unitsOutput.innerHTML = html;
            })
            .catch(err => {
                console.error("❌ API ERROR:", err);
                unitsOutput.innerHTML = '<p class="text-center text-red-500 py-8">Error loading units. Please try again.</p>';
            });
    });

    // Global function to handle unit selection
    window.selectUnit = function(element) {
        const unit = element.getAttribute('data-unit');
        const sizeString = element.getAttribute('data-size');
        
        // Set unit name
        unitNameInput.value = unit;
        
        // Parse and set unit size
        const { size, unit: unitType } = parseUnitSize(sizeString);
        unitSizeInput.value = size;
        
        // Set unit type in select
        if (unitType.includes('Yard')) {
            unitUnitSelect.value = 'Sq. Yard';
        } else {
            unitUnitSelect.value = 'Sq. Feet';
        }
        
        // Highlight selected unit
        document.querySelectorAll('.unit-card').forEach(card => {
            card.style.boxShadow = 'none';
            card.style.transform = 'scale(1)';
        });
        element.style.boxShadow = '0 0 0 3px #3b82f6';
        element.style.transform = 'scale(1.02)';
        
        // Trigger validation
        unitNameInput.dispatchEvent(new Event('input'));
    };

    // Validate unit name format
    unitNameInput.addEventListener('input', function() {
        const pattern = /^[A-Z][A-Z0-9]?\s\d+$/;
        if (this.value && !pattern.test(this.value)) {
            this.setCustomValidity('Format: First letter capital, optional second letter/digit, space, then number (e.g., A 101, B2 205)');
        } else {
            this.setCustomValidity('');
        }
    });

    // If there's an old selected project, load units
    @if(old('project_id'))
        setTimeout(() => {
            projectSelect.dispatchEvent(new Event('change'));
            
            // If there's an old unit name, try to highlight it
            @if(old('unit_name'))
                setTimeout(() => {
                    const oldUnit = '{{ old('unit_name') }}';
                    const unitCard = document.querySelector(`[data-unit="${oldUnit}"]`);
                    if (unitCard && !unitCard.classList.contains('booked')) {
                        selectUnit(unitCard);
                    }
                }, 500);
            @endif
        }, 100);
    @endif
});
</script>
@endpush
@endsection