@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')
@section('content')
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create Project') }}
            </h2>
            <br>
            {{-- <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information and email address.") }}
            </p> --}}
        </header>
        <div class="w-full bg-white p-6 rounded-lg shadow mt-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Generate Documents</h2>

            <!-- Document Form -->
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Select Template -->
                <div>
                    <label for="template" class="block text-gray-700 font-bold mb-2">Select Template</label>
                    <select name="template" id="template"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select a template</option>
                        <option value="agreement">Loan Agreement</option>
                        <option value="sanction_letter">Sanction Letter</option>
                        <option value="disbursement">Disbursement Form</option>
                    </select>
                </div>

                <!-- Select Customer -->
                <div>
                    <label for="customer_id" class="block text-gray-700 font-bold mb-2">Select Customer</label>
                    <select name="customer_id" id="customer_id"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select customer</option>
                        <option value="1">John Doe</option>
                        <option value="2">Jane Smith</option>
                        <option value="3">Ali Khan</option>
                    </select>
                </div>

                <!-- Dynamic Fields Placeholder -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Custom Fields</label>
                    <input type="text" name="loan_amount" placeholder="Loan Amount"
                        class="w-full mb-3 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="loan_term" placeholder="Loan Term (Years)"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Generate Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                        Generate PDF
                    </button>
                </div>
            </form>
        </div>

        <!-- Generated Documents Table -->
        <div class="w-full bg-white p-6 rounded-lg shadow mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Generated Documents</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">#</th>
                            <th class="border border-gray-200 px-4 py-2">Customer</th>
                            <th class="border border-gray-200 px-4 py-2">Document Type</th>
                            <th class="border border-gray-200 px-4 py-2">Created At</th>
                            <th class="border border-gray-200 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2">1</td>
                            <td class="border border-gray-200 px-4 py-2">John Doe</td>
                            <td class="border border-gray-200 px-4 py-2">Loan Agreement</td>
                            <td class="border border-gray-200 px-4 py-2">2025-05-01</td>
                            <td class="border border-gray-200 px-4 py-2 space-x-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <a href="#" class="text-green-600 hover:underline">Download</a>
                            </td>
                        </tr>
                        <!-- More rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>




    </section>
@endsection
