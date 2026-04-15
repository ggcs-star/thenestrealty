@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">

    <div class="bg-white shadow-lg rounded-xl p-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Loan</h2>

        <form method="POST" action="{{ route('loan.update', $loan->id) }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Customer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                    <select name="customer_id" class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ $loan->customer_name == $customer->name ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Booking -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Booking</label>
                    <select name="booking_id" class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($Booking as $Book)
                            <option value="{{ $Book->id }}"
                                {{ $loan->booking_id == $Book->id ? 'selected' : '' }}>
                                {{ $Book->booking_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Unit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                    <input type="text" value="{{ $loan->unit_name }}" readonly
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100" />
                </div>

                <!-- Bank -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                    <input type="text" name="bank_name"
                        value="{{ $loan->bank_name }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Loan Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Loan Amount</label>
                    <input type="number" name="loan_amount"
                        value="{{ $loan->loan_amount }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Loan Stage -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="text-sm font-medium text-gray-700">Loan Stage</label>

                        <button type="button"
                            onclick="openStageModal()"
                            class="text-xs text-blue-600 hover:underline">
                            + Add Stage
                        </button>
                    </div>

                    <select name="loan_stage_id"
                        class="w-full border rounded-md px-3 py-2">

                        @foreach($stages as $stage)
                            <option value="{{ $stage->id }}"
                                {{ $loan->loan_stage_id == $stage->id ? 'selected' : '' }}>
                                {{ $stage->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="4"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ $loan->notes }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('loan.list') }}"
                    class="px-4 py-2 border rounded-md">Cancel</a>

                <button type="submit"
                    class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold px-6 py-2 rounded-md transition">
                    Update Loan
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🔥 Stage Modal SAME -->
<div id="stageModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl p-5 w-96">

        <h3 class="text-lg font-semibold mb-3">Add Loan Stage</h3>

        <form method="POST" action="{{ route('loan-stages.store') }}">
            @csrf

            <input type="text" name="name" placeholder="Stage Name"
                class="w-full border px-3 py-2 rounded-md mb-3" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeStageModal()" class="px-3 py-1 border rounded">Cancel</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
            </div>

        </form>
    </div>
</div>

<script>
function openStageModal() {
    document.getElementById('stageModal').classList.remove('hidden');
}
function closeStageModal() {
    document.getElementById('stageModal').classList.add('hidden');
}
</script>

@endsection