@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="w-min-screen p-2 mx-auto bg-white mt-12 p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Employee</h2>

    <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="John Doe">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone Number --}}
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input
                type="tel"
                name="phone_number"
                id="phone_number"
                value="{{ old('phone_number') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="e.g., 9876543210">
            @error('phone_number')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="name@company.com">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Birthdate --}}
        <div>
            <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Birthdate</label>
            <input
                type="date"
                name="birthdate"
                id="birthdate"
                value="{{ old('birthdate') }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('birthdate')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Designation --}}
        <div>
            <label for="designation" class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
            <select
                name="designation"
                id="designation"
                class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="" disabled>Select designation</option>
                <option value="Manager"  {{ old('designation') == 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Employee" {{ old('designation') == 'Employee' ? 'selected' : '' }}>Employee</option>
            </select>
            @error('designation')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select
                name="status"
                id="status"
                class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold px-6 py-2 rounded-md transition shadow-sm">
                Create Employee
            </button>
        </div>

    </form>
</div>
@endsection
