@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">

        <!-- Heading INSIDE -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            {{ __('Create Project') }}
        </h2>

        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                    <input type="text" name="name"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Builder Name</label>
                    <input type="text" name="builder_name"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Builder Contact Number</label>
                    <input type="number" name="builder_number"
                        class="w-full h-11 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-[#AC7E2C]">
                </div>

               <div class="md:col-span-2">

    @if(auth('employee')->check())

        @php
            $user = auth('employee')->user();
        @endphp

        {{-- ✅ Manager --}}
        @if($user->isManager())

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Assign Employee
            </label>

            <select name="assigned_employee"
                class="w-full h-11 border border-gray-300 rounded-lg px-4">

                <option value="" disabled selected>Select your employee</option>

                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach

            </select>

        {{-- ✅ Normal Employee --}}
        @else

            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                <input type="hidden" name="assigned_employee" value="{{ $user->id }}">
                <p class="text-sm text-gray-600">
                    Assigned to:
                    <span class="font-semibold text-gray-800">
                        {{ $user->name }}
                    </span>
                </p>
            </div>

        @endif

    {{-- ✅ Admin --}}
    @else

        <label class="block text-sm font-medium text-gray-700 mb-1">Assign Employee</label>

        <select name="assigned_employee"
            class="w-full h-11 border border-gray-300 rounded-lg px-4">

            <option value="" disabled selected>Select an employee</option>

            @foreach($employees as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
            @endforeach

        </select>

    @endif

</div>

            </div>

            <!-- Upload -->
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-4">

    <!-- Label -->
    <div>
        <label class="block text-sm font-semibold text-gray-800">
            Upload Documents
        </label>
        <p class="text-xs text-gray-500 mt-1">
            Upload one or more Excel files to import unit data.
        </p>
    </div>

    <!-- File Input -->
    <div class="flex items-center justify-center w-full">
        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-[#AC7E2C] hover:bg-gray-50 transition">

            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <!-- Icon -->
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h1m4 0h1a4 4 0 014 4m-9-4V5m0 0l-3 3m3-3l3 3" />
                </svg>

                <p class="text-sm text-gray-600">
                    <span class="font-medium text-[#AC7E2C]">Click to upload</span> or drag & drop
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Excel files only (.xlsx, .xls)
                </p>
            </div>

            <input type="file" name="documents[]" multiple class="hidden">
        </label>
    </div>

    <!-- Download Demo -->
    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
        <div>
            <p class="text-sm font-medium text-gray-700">
                Need a sample format?
            </p>
            <p class="text-xs text-gray-500">
                Download the demo Excel file to understand structure.
            </p>
        </div>

        <a href="{{ asset('demo.xlsx') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-white bg-[#AC7E2C] px-4 py-2 rounded-lg hover:bg-[#94691f] transition shadow-sm">

            <!-- Download Icon -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-5l-4 4m0 0l-4-4m4 4V4" />
            </svg>

            Download Demo
        </a>
    </div>

</div>
            </div>

            <!-- Button -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-medium px-6 py-2.5 rounded-lg transition">
                    Create Project
                </button>
            </div>

        </form>
    </div>
</section>
@endsection