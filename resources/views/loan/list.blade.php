@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="px-6 py-6 w-full">

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Loan Records</h2>
            <p class="text-sm text-gray-500">Manage and track all loan entries</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">

            @if($loans->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    No loan records found
                </div>
            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Customer</th>
                                <th class="px-4 py-3 text-left">Booking ID</th>
                                <th class="px-4 py-3 text-left">Unit</th>
                                <th class="px-4 py-3 text-left">Bank</th>
                                <th class="px-4 py-3 text-left">Employee</th>
                                <th class="px-4 py-3 text-left">Amount</th>
                                <th class="px-4 py-3 text-left">Stage</th>
                                <th class="px-4 py-3 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($loans as $index => $loan)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 text-gray-500">
                                        {{ $loans->firstItem() + $index }}
                                    </td>

                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $loan->customer_name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $loan->booking->booking_id ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $loan->unit_name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $loan->bank->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $loan->employee_name }}
                                    </td>

                                    <td class="px-4 py-3 text-green-600 font-semibold">
                                        {{ amountToPoints($loan->loan_amount) }}
                                    </td>

                                    <td class="px-4 py-3">

                                        <form method="POST" action="{{ route('loan.updateStage', $loan->id) }}">
                                            @csrf

                                            <select name="loan_stage_id" onchange="this.form.submit()"
                                                class="text-xs px-2 py-1 rounded-full border border-gray-200 focus:ring-0">

                                                @foreach($stages as $stage)
                                                    <option value="{{ $stage->id }}" {{ $loan->loan_stage_id == $stage->id ? 'selected' : '' }}>
                                                        {{ $stage->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                        </form>

                                    </td>

                                    <td class="px-4 py-3 text-center">
                                      <a href="{{ route('loan.edit', $loan->id) }}"
   class="px-3 py-1 text-xs bg-[#AC7E2C] text-white rounded-lg">
   Edit
</a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            @endif

        </div>

        <div class="mt-6">
            {{ $loans->withQueryString()->links() }}
        </div>

    </section>
@endsection