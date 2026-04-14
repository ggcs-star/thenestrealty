@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Edit Channel Partner</h2>
        <p class="text-sm text-gray-500">Update partner details</p>
    </div>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

        <form method="POST" action="{{ route('partner.update', $partner->id) }}">
            @csrf
            @method('PUT')

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Name -->
                <div>
                    <label class="text-sm text-gray-600">Partner Name</label>
                    <input type="text" name="partner_name" value="{{ old('partner_name', $partner->partner_name) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C] focus:ring-1 focus:ring-[#AC7E2C]">
                </div>

                <!-- Contact -->
                <div>
                    <label class="text-sm text-gray-600">Contact Number</label>
                    <input type="text" name="number_contact" value="{{ old('number_contact', $partner->number_contact) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="mail_id" value="{{ old('mail_id', $partner->mail_id) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- DOB -->
                <div>
                    <label class="text-sm text-gray-600">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $partner->date_of_birth) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- Aadhaar -->
                <div>
                    <label class="text-sm text-gray-600">Aadhaar Number</label>
                    <input type="text" name="aadhaar_card" value="{{ old('aadhaar_card', $partner->aadhaar_card) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- PAN -->
                <div>
                    <label class="text-sm text-gray-600">PAN Number</label>
                    <input type="text" name="pan_card" value="{{ old('pan_card', $partner->pan_card) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- Commission -->
                <div>
                    <label class="text-sm text-gray-600">Commission</label>
                    <input type="text" name="commission" value="{{ old('commission', $partner->commission) }}"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#AC7E2C]">
                </div>

                <!-- Status -->
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white focus:ring-1 focus:ring-[#AC7E2C]">
                        <option value="active" {{ old('status', $partner->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $partner->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    Update Partner
                </button>

            </div>

        </form>

    </div>

</section>
@endsection