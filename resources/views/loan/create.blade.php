@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl" x-data="loanForm()">
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
                        <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <select id="bank_id" name="bank_id"
                                    class="flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select a bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            <button @click.prevent="showBankModal = true" type="button"
                                    class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Add</span>
                            </button>
                        </div>
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

    <!-- Add Bank Modal -->
    <div x-show="showBankModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="showBankModal = false" x-show="showBankModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showBankModal" @click.stop x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add New Bank</h3>
                    <div class="mt-2">
                        <input type="text" x-model="newBankName" placeholder="Enter bank name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <p x-show="bankError" x-text="bankError" class="text-red-500 text-xs mt-1"></p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="addNewBank()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button @click="showBankModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
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

function loanForm() {
        return {
            showBankModal: false,
            newBankName: '',
            bankError: '',
            addNewBank() {
                if (!this.newBankName.trim()) {
                    this.bankError = 'Bank name cannot be empty.';
                    return;
                }
                this.bankError = '';

                fetch('{{ route("banks.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name: this.newBankName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const bankSelect = document.getElementById('bank_id');
                        const newOption = document.createElement('option');
                        newOption.value = data.bank.id;
                        newOption.textContent = data.bank.name;
                        bankSelect.appendChild(newOption);
                        // Keep selection on the newly created bank
                        bankSelect.value = data.bank.id;
                        bankSelect.dispatchEvent(new Event('change'));

                        this.showBankModal = false;
                        this.newBankName = '';
                    } else {
                        this.bankError = data.message || 'An error occurred.';
                    }
                })
                .catch(error => {
                    this.bankError = 'Request failed. Please try again.';
                    console.error('Error:', error);
                });
            }
        }
    }
</script>
@endsection