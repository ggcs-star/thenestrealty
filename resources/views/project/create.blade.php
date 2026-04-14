@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="px-6 pb-18 mx-auto mt-6">
        <header class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ __('Create Project') }}
            </h2>
        </header>

        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-xl shadow-md space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="builder_name" class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                    <input type="text" name="builder_name" id="builder_name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="builder_number" class="block text-sm font-medium text-gray-700 mb-1">Builder Contact
                        Number</label>
                    <input type="number" name="builder_number" id="builder_number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    @if(auth('employee')->check())
                        {{-- Agar employee login hai to hidden field --}}
                        <input type="hidden" name="assigned_employee" value="{{ auth('employee')->id() }}">
                        <p class="text-sm text-gray-600">
                            Assigned to: <strong>{{ auth('employee')->user()->name }}</strong>
                        </p>
                    @else
                        {{-- Agar admin login hai to dropdown dikhana --}}
                        <label for="assigned_employee" class="block text-sm font-medium text-gray-700 mb-1">Assign
                            Employee</label>
                        <select name="assigned_employee" id="assigned_employee"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="" disabled selected>Select an employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

            </div>

            <div>
                <label for="documents" class="block text-sm font-medium text-gray-700 mb-1">Upload Documents</label>
                <input type="file" name="documents[]" id="documents" multiple
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">You can upload multiple Excel files (.xlsx, .xls) to extract units.
                </p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-6 rounded-lg transition">
                    Create Project
                </button>
            </div>
        </form>
    </section>
@endsection