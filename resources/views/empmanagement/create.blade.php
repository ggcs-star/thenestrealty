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
        <h2 class="text-xl font-semibold text-gray-900">Create Employee</h2>
        <p class="text-xs text-gray-500">Add new employee details</p>
    </div>
<form action="{{ route('employees.store') }}" method="POST" class="space-y-4">            @csrf

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NAME -->
                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]"
                        placeholder="John Doe">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PHONE -->
                <div>
                    <label class="text-sm text-gray-600">Phone Number</label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]"
                        placeholder="9876543210">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]"
                        placeholder="name@company.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600">Birthdate</label>
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                    @error('birthdate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DESIGNATION -->
                <div>
                    <label class="text-sm text-gray-600">Designation</label>
                    <select name="designation"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="">Select designation</option>
                        <option value="Manager" {{ old('designation')=='Manager'?'selected':'' }}>Manager</option>
                        <option value="Employee" {{ old('designation')=='Employee'?'selected':'' }}>Employee</option>
                    </select>
                    @error('designation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- STATUS -->
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="active" {{ old('status','active')=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CONFIRM PASSWORD -->
                <div>
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F] transition">
                    Create Employee
                </button>
            </div>

        </form>

    </div>

</section>
@endsection