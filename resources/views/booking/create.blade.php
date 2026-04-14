@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">            <h2 class="text-2xl font-semibold text-gray-900">Create Booking</h2>

            {{-- Display ALL Validation Errors at the top --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 rounded relative mb-4" role="alert">
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
                <div class="bg-green-50 border border-green-200 rounded-lg text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
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
                    @if(isset($projects) && is_countable($projects))
                        <p class="text-sm text-gray-500 mt-1">Projects count: {{ count($projects) }}</p>
                    @endif
                </div>

                <!-- All Units Display -->
                <div id="all-units3-container" style="display:none;">
                    <h3 style="margin:10px 0; font-weight:bold;">Units List</h3>

                    <div id="all-units3" style="display:grid; grid-template-columns: repeat(4, 1fr); gap:10px;">
                    </div>
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
                <div id="units-output" style="margin-top:20px;">demo</div>
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
                        class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-6 rounded-lg transition">
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                document.addEventListener('change', function (e) {

                    if (e.target && e.target.id === 'project_id3') {

                        const projectId = e.target.value;

                        const output = document.getElementById('units-output');

                        if (!output) return;

                        if (!projectId) {
                            output.innerHTML = '';
                            return;
                        }

                        output.innerHTML = "Loading...";

                        fetch(`/api/projects/${projectId}/units`)
                            .then(res => res.json())
                            .then(data => {

                                console.log("📦 API DATA:", data);

                                if (!data.units || data.units.length === 0) {
                                    output.innerHTML = "No units found";
                                    return;
                                }

                                let html = `<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">`;

                                const bookedUnits = data.booked_units || [];

                                data.units.forEach(unit => {

                                    const size = data.unit_sizes?.[unit] || 'N/A';
                                    const isBooked = bookedUnits.includes(unit);

                                    html += `
                                    <div style="
                                        border:1px solid #ccc;
                                        padding:10px;
                                        border-radius:6px;
                                        text-align:center;
                                        background:${isBooked ? '#ddd' : '#c8f7c5'};
                                    ">
                                        <div><b>${unit}</b></div>
                                        <div style="font-size:12px;">${size}</div>
                                    </div>
                                `;
                                });

                                html += `</div>`;

                                output.innerHTML = html;

                            })
                            .catch(err => {
                                console.error("❌ API ERROR:", err);
                            });

                    }

                });

            });
        </script>
    @endpush
@endsection