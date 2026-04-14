@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-min-screen p-6 mx-auto mt-10 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Edit Employee</h2>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-sm text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="w-full border px-3 py-2 rounded 
                       @error('name') border-red-500 @enderror">

                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-sm text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" class="w-full border px-3 py-2 rounded 
                       @error('phone_number') border-red-500 @enderror">

                @error('phone_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full border px-3 py-2 rounded 
                       @error('email') border-red-500 @enderror">

                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Birthdate --}}
            <div>
                <label class="block text-sm text-gray-700">Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate', $employee->birthdate) }}" class="w-full border px-3 py-2 rounded 
                       @error('birthdate') border-red-500 @enderror">

                @error('birthdate')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Designation --}}
            <div>
                <label class="block text-sm text-gray-700">Designation</label>
                <select name="designation" class="w-full border px-3 py-2 rounded 
                        @error('designation') border-red-500 @enderror">

                    <option value="Manager" {{ old('designation', $employee->designation) == 'Manager' ? 'selected' : '' }}>
                        Manager</option>
                    <option value="Employee" {{ old('designation', $employee->designation) == 'Employee' ? 'selected' : '' }}>
                        Employee</option>
                </select>

                @error('designation')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm text-gray-700">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded 
                        @error('status') border-red-500 @enderror">

                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive
                    </option>
                </select>

                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Optional --}}
            <div>
                <label class="block text-sm text-gray-700">New Password (Optional)</label>
                <input type="password" name="password" autocomplete="new-password" class="w-full border px-3 py-2 rounded 
                   @error('password') border-red-500 @enderror">

                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded">
            </div>

            <button class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white px-4 py-2 rounded">
                Update Employee
            </button>
        </form>

    </div>
@endsection