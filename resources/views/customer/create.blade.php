@php
$hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-4 mx-auto mt-10"
    x-data="{ referral: '{{ old('referred_by') }}' }" {{-- Alpine state --}}
    x-cloak> {{-- hide flashes --}}
    <header class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Create Customer</h2>
    </header>

    <form action="{{ route('customers.store') }}"
        method="POST"
        class="bg-white p-8 rounded-xl shadow-md space-y-6">
        @csrf
        <input type="hidden" name="employee_id" value="{{ auth('employee')->id() }}">
        {{-- ——— Grid of basic fields ——— --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Contact Number --}}
            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input type="tel" id="contact_number" name="contact_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required pattern="^[6-9][0-9]{9}$" minlength="10" maxlength="10" title="Mobile number must be of 10 digits">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email ID</label>
                <input type="email" id="email" name="email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- DOB --}}
            <div>
                <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" id="dob" name="dob"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Aadhaar --}}
            <div>
                <label for="aadhar_number" class="block text-sm font-medium text-gray-700 mb-1">Aadhaar Number</label>
                <input type="text" id="aadhar_number" name="aadhar_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required pattern="\d{12}" minlength="12" maxlength="12" title="Aadhaar number must be exactly 12 digits">
            </div>

            {{-- PAN --}}
            <div>
                <label for="pan_number" class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                <input type="text" id="pan_number" name="pan_number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" minlength="10" maxlength="10" title="PAN number must be 10 characters: 5 uppercase letters, 4 digits, 1 uppercase letter (e.g., ABCDE1234F)">
            </div>

            {{-- Referred-by select (controls Alpine state) --}}
            <div class="md:col-span-2">
                <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred By</label>
                <select id="referred_by" name="referred_by"
                    x-model="referral" {{-- two-way bind --}}
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="" disabled :selected="!referral">Select an option</option>
                    <option value="via_builder">Via Builder</option>
                    <option value="via_partner">Via Partner</option>
                </select>
            </div>

            {{-- Builder field (shows only if referral === 'via_builder') --}}
            <div class="md:col-span-1"
                x-show="referral === 'via_builder'"
                x-transition>
                <label for="builder_name" class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                <select id="builder_name" name="builder_name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    :required="referral === 'via_builder'">
                    <option value="" disabled selected>Select a builder</option>
                    @foreach($builders as $builder)
                    <option value="{{ $builder }}">{{ $builder }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Partner field (shows only if referral === 'via_partner') --}}
            <div class="md:col-span-1"
                x-show="referral === 'via_partner'"
                x-transition>
                <label for="partner_name" class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
                <select id="partner_name" name="partner_name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    :required="referral === 'via_partner'">
                    <option value="" disabled selected>Select a partner</option>
                    @foreach($partners as $partner)
                    <option value="{{ $partner }}">{{ $partner }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Create Customer
            </button>
        </div>
    </form>
</section>
@endsection