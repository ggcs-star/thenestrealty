@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Edit Customer</h2>
        <p class="text-sm text-gray-500">Update customer details</p>
    </div>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN CARD (FULL WIDTH LIKE COMMISSION) -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Name -->
                <div>
                    <label class="text-sm text-gray-600">Name</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- Contact -->
                <div>
                    <label class="text-sm text-gray-600">Contact</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $customer->contact_number) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $customer->dob) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- Aadhaar -->
                <div>
                    <label class="text-sm text-gray-600">Aadhaar Number</label>
                    <input type="text" name="aadhar_number" value="{{ old('aadhar_number', $customer->aadhar_number) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- PAN -->
                <div>
                    <label class="text-sm text-gray-600">PAN Number</label>
                    <input type="text" name="pan_number" value="{{ old('pan_number', $customer->pan_number) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- Referred -->
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Referred By</label>
                    <select name="referred_by" id="referred_by"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]"
                        onchange="toggleReferralFields()">
                        <option value="">Select</option>
                        <option value="via_builder" {{ old('referred_by', $customer->referred_by) === 'via_builder' ? 'selected' : '' }}>Via Builder</option>
                        <option value="via_partner" {{ old('referred_by', $customer->referred_by) === 'via_partner' ? 'selected' : '' }}>Via Partner</option>
                    </select>
                </div>

                <!-- Builder -->
                <div id="builder_field" class="hidden">
                    <label class="text-sm text-gray-600">Builder Name</label>
                    <input type="text" name="builder_name" value="{{ old('builder_name', $customer->builder_name) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">
                </div>

                <!-- Partner -->
                <div id="partner_field" class="hidden">
                    <label class="text-sm text-gray-600">Partner Name</label>
                    <input type="text" name="partner_name" value="{{ old('partner_name', $customer->partner_name) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('customer.list') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-[#AC7E2C] text-white hover:bg-[#8C651F]">
                    Update Customer
                </button>
            </div>

        </form>

    </div>

</section>

<script>
function toggleReferralFields() {
    const val = document.getElementById('referred_by').value;
    document.getElementById('builder_field').style.display = val === 'via_builder' ? 'block' : 'none';
    document.getElementById('partner_field').style.display = val === 'via_partner' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleReferralFields);
</script>
@endsection