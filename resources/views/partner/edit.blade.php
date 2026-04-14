@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto mt-10">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Channel Partner</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-3 rounded-lg mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('partner.update', $partner->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <!-- Partner Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Partner Name</label>
                <input type="text" name="partner_name" value="{{ old('partner_name', $partner->partner_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Contact Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input type="text" name="number_contact" maxlength="20" value="{{ old('number_contact', $partner->number_contact) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="mail_id" value="{{ old('mail_id', $partner->mail_id) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Date of Birth -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $partner->date_of_birth) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Aadhaar Card -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aadhaar Card</label>
                <input type="text" name="aadhaar_card" maxlength="12" value="{{ old('aadhaar_card', $partner->aadhaar_card) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- PAN Card -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PAN Card</label>
                <input type="text" name="pan_card" maxlength="10" value="{{ old('pan_card', $partner->pan_card) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Commission -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Commission (%)</label>
                <input type="text" name="commission" value="{{ old('commission', $partner->commission) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="active" {{ old('status', $partner->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $partner->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-span-1 md:col-span-2 pt-4">
                <button type="submit"
                        class="w-full bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Partner
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
