@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Edit Employee</h2>
        <p class="text-sm text-gray-500">Update employee details</p>
    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NAME -->
                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <input type="text" name="name"
                        value="{{ old('name', $employee->name) }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('name') border-red-500 @enderror">

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PHONE -->
                <div>
                    <label class="text-sm text-gray-600">Phone Number</label>
                    <input type="text" name="phone_number"
                        value="{{ old('phone_number', $employee->phone_number) }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('phone_number') border-red-500 @enderror">

                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $employee->email) }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600">Birthdate</label>
                    <input type="date" name="birthdate"
                        value="{{ old('birthdate', $employee->birthdate) }}"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('birthdate') border-red-500 @enderror">

                    @error('birthdate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DESIGNATION -->
             <div>
    <label class="text-sm text-gray-600">Designation</label>
    <select name="designation" id="designation"
        onchange="toggleManager()"
        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg">

        <option value="Manager"
            {{ old('designation', $employee->designation) == 'Manager' ? 'selected' : '' }}>
            Manager
        </option>

        <option value="Employee"
            {{ old('designation', $employee->designation) == 'Employee' ? 'selected' : '' }}>
            Employee
        </option>
    </select>
</div>

<!-- ✅ Manager Dropdown -->
<div id="managerField" style="display:none;">
    <label class="text-sm text-gray-600">Assign Manager</label>

    <select name="manager_id" id="manager_id"
        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg">

        <option value="">Select Manager</option>

        @foreach($managers as $manager)
            <option value="{{ $manager->id }}"
                {{ old('manager_id', $employee->manager_id) == $manager->id ? 'selected' : '' }}>
                {{ $manager->name }}
            </option>
        @endforeach
    </select>
    @error('manager_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        
    @enderror
</div>

                <!-- STATUS -->
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('status') border-red-500 @enderror">

                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="text-sm text-gray-600">New Password (Optional)</label>
                    <input type="password" name="password"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C] @error('password') border-red-500 @enderror">

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CONFIRM -->
                <div>
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-6">
                <button
                    class="px-6 py-2 bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F] transition">
                    Update Employee
                </button>
            </div>

        </form>

    </div>

</section>

<script>
function toggleManager() {
    let role = document.getElementById('designation').value;
    let managerField = document.getElementById('managerField');
    let managerInput = document.getElementById('manager_id');

    if (role === 'Employee') {
        managerField.style.display = 'block';
    } else {
        managerField.style.display = 'none';

        managerInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', toggleManager);
</script>
@endsection