@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Loan Management Form</h2>

            <form method="POST" action="{{ route('loan.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select
                            Customer</label>
                        <select name="customer_id" id="customer_id"
                            class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Booking ID -->
                    <div>
                        <label for="booking_id" class="block text-sm font-medium text-gray-700 mb-1">Select Booking
                            ID</label>
                        <select name="booking_id" id="booking_id"
                            class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Booking Id</option>
                            @foreach ($Booking as $Book)
                                <option value="{{ $Book->id }}">{{ $Book->booking_id}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unit Name -->
                    <div>
                        <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                        <select name="unit_name" id="unit_name"
                            class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Unit</option>
                            @foreach ($Booking as $Book)
                                <option value="{{ $Book->id }}">{{ $Book->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bank Name -->
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>

                    {{-- Sirf admin ke liye Employee select dikhana hai --}}
                    @unless(auth('employee')->check())
                        <!-- Employee Name -->
                        <div>
                            <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-1">Employee
                                Name</label>
                            <select name="employee_name" id="employee_name"
                                class="px-3 py-2 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Employee Id</option>
                                @foreach ($Emp as $ply)
                                    <option value="{{ $ply->id }}">{{ $ply->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Employee Number -->
                        @if (!auth('employee')->check())
                            <!-- Sirf admin ko show karega -->
                            <div>
                                <label for="employee_number" class="block text-sm font-medium text-gray-700 mb-1">Employee
                                    Number</label>
                                <input type="text" name="employee_number" id="employee_number" placeholder="Employee Number"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                            </div>
                        @else
                            <!-- Employee login hone par hidden field me phone_number bhej do -->
                            <input type="hidden" name="employee_number" value="{{ auth('employee')->user()->phone_number }}">
                        @endif

                    @endunless


                    <!-- Loan Amount -->
                    <div>
                        <label for="loan_amount" class="block text-sm font-medium text-gray-700 mb-1">Loan Amount</label>
                        <input type="number" name="loan_amount" id="loan_amount" placeholder="Loan Amount"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <!-- Loan Stage -->
                    <!-- Loan Stage -->
                    <div class="mb-3">

                        <div class="flex justify-between items-center mb-1">
                            <label class="text-sm font-medium text-gray-700">Loan Stage</label>

                            <button type="button" onclick="openStageModal()" class="text-xs text-blue-600 hover:underline">
                                + Add Stage
                            </button>
                        </div>

                        <select name="loan_stage_id" class="w-full border rounded-md px-3 py-2" required>
                            <option value="">Select Stage</option>

                            @foreach($stages as $stage)
                                <option value="{{ $stage->id }}">
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        placeholder="Additional information..."></textarea>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white font-semibold px-6 py-2 rounded-md transition">
                        Submit Loan
                    </button>
                </div>
            </form>
        </div>
        <!-- 🔥 Stage Modal -->
<div id="stageModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">

    <div class="bg-white rounded-xl p-5 w-96">

        <h3 class="text-lg font-semibold mb-3">Add Loan Stage</h3>

        <form method="POST" action="{{ route('loan-stages.store') }}">
            @csrf

            <input type="text" name="name" placeholder="Stage Name"
                class="w-full border px-3 py-2 rounded-md mb-3" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeStageModal()"
                    class="px-3 py-1 border rounded">Cancel</button>

                <button class="px-3 py-1 bg-blue-600 text-white rounded">
                    Save
                </button>
            </div>

        </form>

    </div>

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