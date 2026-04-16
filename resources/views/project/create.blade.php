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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Documents</label>
                <input type="file" name="documents[]" multiple
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#AC7E2C]">
                <p class="text-xs text-gray-500 mt-1">
                    You can upload multiple Excel files (.xlsx, .xls) to extract units.
                </p>
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