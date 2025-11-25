@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-2 mx-auto mt-10">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Register Channel Partner</h2>
        {{-- You can place instructions or a subtitle here if needed --}}
    </header>

    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <form action="{{ route('partner.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Partner Name -->
            <div class="col-span-1">
                <label for="partner_name" class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
                <input type="text" id="partner_name" name="partner_name"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter Partner Name" required>
            </div>

            <!-- Contact Person -->
            <div class="col-span-1">
                <label for="number_contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                <input type="tel" id="number_contact" name="number_contact"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter Contact Person" required>
            </div>

            <!-- Email -->
            <div class="col-span-1">
                <label for="mail_id" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="mail_id" name="mail_id"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter Email Address" required>
            </div>

            <!-- Date of Birth -->
            <div class="col-span-1">
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Aadhaar Card -->
            <div class="col-span-1">
                <label for="aadhaar_card" class="block text-sm font-medium text-gray-700 mb-1">Aadhaar Card</label>
                <input type="number" id="aadhaar_card" name="aadhaar_card"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter Aadhaar Number" required>
            </div>

            <!-- PAN Card -->
            <div class="col-span-1">
                <label for="pan_card" class="block text-sm font-medium text-gray-700 mb-1">PAN Card</label>
                <input type="text" id="pan_card" name="pan_card"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter PAN Number" required>
            </div>

            <!-- Commission -->
            <div class="col-span-1">
                <label for="commission" class="block text-sm font-medium text-gray-700 mb-1">Commission</label>
                <input type="text" id="commission" name="commission"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., 10% or ₹5000" required>
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Submit Button (spans both columns) -->
            <div class="col-span-1 md:col-span-2 pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Register Partner
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
