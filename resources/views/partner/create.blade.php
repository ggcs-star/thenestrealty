@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 md:p-6">

        <!-- HEADER INSIDE -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Register Channel Partner</h2>
            <p class="text-xs text-gray-500">Add new partner details</p>
        </div>

        <form action="{{ route('partner.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Partner Name -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Partner Name</label>
                    <input type="text" name="partner_name"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('partner_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Contact -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Contact Person</label>
                    <input type="tel" name="number_contact"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('number_contact')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Email</label>
                    <input type="email" name="mail_id"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('mail_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Aadhaar -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Aadhaar Number</label>
                    <input type="text" name="aadhaar_card"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('aadhaar_card')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror   
                </div>

                <!-- PAN -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">PAN Number</label>
                    <input type="text" name="pan_card"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('pan_card')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Commission -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Commission</label>
                    <input type="text" name="commission"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:ring-1 focus:ring-[#AC7E2C]">
                        @error('commission')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Status</label>
                    <select name="status"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 bg-white focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 pt-2">

                <a href="{{ route('partner.list') }}"
                    class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                    class="px-6 py-2.5 text-sm rounded-lg bg-[#AC7E2C] text-white hover:bg-[#8C651F]">
                    Register Partner
                </button>

            </div>

        </form>

    </div>

</section>
@endsection