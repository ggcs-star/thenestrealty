@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-2 mx-auto mt-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Customer</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('customers.update', $customer->id) }}" class="bg-white p-8 rounded-xl shadow-md space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Contact Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $customer->contact_number) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Date of Birth -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="dob" value="{{ old('dob', $customer->dob) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Aadhar Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aadhar Number</label>
                <input type="text" name="aadhar_number" value="{{ old('aadhar_number', $customer->aadhar_number) }}"
                    maxlength="12"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- PAN Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                <input type="text" name="pan_number" value="{{ old('pan_number', $customer->pan_number) }}"
                    maxlength="10"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Referred By -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Referred By</label>
                <select name="referred_by" id="referred_by"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required onchange="toggleReferralFields()">
                    <option value="">Select</option>
                    <option value="via_builder" {{ old('referred_by', $customer->referred_by) === 'via_builder' ? 'selected' : '' }}>Via Builder</option>
                    <option value="via_partner" {{ old('referred_by', $customer->referred_by) === 'via_partner' ? 'selected' : '' }}>Via Partner</option>
                </select>
            </div>

            <!-- Builder Name -->
            <div id="builder_field" class="md:col-span-1 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                <input type="text" name="builder_name" value="{{ old('builder_name', $customer->builder_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Partner Name -->
            <div id="partner_field" class="md:col-span-1 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
                <input type="text" name="partner_name" value="{{ old('partner_name', $customer->partner_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-6 rounded-lg transition">
                Update Customer
            </button>
        </div>
    </form>
</section>

<script>
    function toggleReferralFields() {
        const referredBy = document.getElementById('referred_by').value;
        document.getElementById('builder_field').style.display = referredBy === 'via_builder' ? 'block' : 'none';
        document.getElementById('partner_field').style.display = referredBy === 'via_partner' ? 'block' : 'none';
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', toggleReferralFields);
</script>
@endsection
