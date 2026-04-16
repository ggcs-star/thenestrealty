@php
$hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl"
        x-data="{ referral: '{{ old('referred_by') }}' }"
    x-cloak>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 md:p-6">

        <!-- Heading INSIDE -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Create Customer
        </h2>

        <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="employee_id" value="{{ auth('employee')->id() }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('name')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                </div>

                <!-- Contact -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                    <input type="tel" name="contact_number"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('contact_number')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email ID</label>
                    <input type="email" name="email"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('email')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                </div>

                <!-- DOB -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="dob"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('dob')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror

                </div>

                <!-- Aadhaar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Aadhaar Number</label>
                    <input type="text" name="aadhar_number"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('aadhar_number')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                        
                </div>

                <!-- PAN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                    <input type="text" name="pan_number"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        @error('pan_number')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                </div>

                <!-- Referral -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referred By</label>
                    <select name="referred_by" x-model="referral"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        <option value="" disabled>Select an option</option>
                        <option value="via_builder">Via Builder</option>
                        <option value="via_partner">Via Partner</option>
                    </select>
                    @error('referred_by')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror

                </div>

                <!-- Builder -->
                <div x-show="referral === 'via_builder'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                    <select name="builder_name"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        <option value="" disabled selected>Select Builder</option>
                        @foreach($builders as $builder)
                            <option value="{{ $builder }}">{{ $builder }}</option>
                        @endforeach
                    </select>
                    @error('builder_name')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror

                </div>

                <!-- Partner -->
                <div x-show="referral === 'via_partner'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
                    <select name="partner_name"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                        <option value="" disabled selected>Select Partner</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner }}">{{ $partner }}</option>
                        @endforeach
                    </select>
                    @error('partner_name')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                </div>

            </div>

            <!-- Button -->
            <div class="flex justify-end pt-2">
                <button
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-medium px-6 py-2.5 rounded-lg transition">
                    Create Customer
                </button>
            </div>

        </form>
    </div>
</section>
@endsection