@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Register Channel Partner</h2>
        <p class="text-sm text-gray-500">Add new partner details</p>
    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

        <form action="{{ route('partner.store') }}" method="POST">
            @csrf

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Partner Name -->
                <div>
                    <label class="text-sm text-gray-600">Partner Name</label>
                    <input type="text" name="partner_name"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]"
                        placeholder="Enter Partner Name">
                </div>

                <!-- Contact -->
                <div>
                    <label class="text-sm text-gray-600">Contact Person</label>
                    <input type="tel" name="number_contact"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]"
                        placeholder="Enter Contact Number">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="mail_id"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]"
                        placeholder="Enter Email">
                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- Aadhaar -->
                <div>
                    <label class="text-sm text-gray-600">Aadhaar Number</label>
                    <input type="text" name="aadhaar_card"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]"
                        placeholder="Enter Aadhaar Number">
                </div>

                <!-- PAN -->
                <div>
                    <label class="text-sm text-gray-600">PAN Number</label>
                    <input type="text" name="pan_card"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]"
                        placeholder="Enter PAN">
                </div>

                <!-- Commission -->
                <div>
                    <label class="text-sm text-gray-600">Commission</label>
                    <input type="text" name="commission"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]"
                        placeholder="e.g. 10% or ₹5000">
                </div>

                <!-- Status -->
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 mt-6">

                <a href="{{ route('partner.list') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-[#AC7E2C] text-white hover:bg-[#8C651F]">
                    Register Partner
                </button>

            </div>

        </form>

    </div>

</section>
@endsection