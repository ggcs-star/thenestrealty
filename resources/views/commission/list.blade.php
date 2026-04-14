@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')

<section class="px-6 mx-auto mt-10 md:mt-12 max-w-7xl">

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 md:p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Commission Management</h2>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm text-gray-700">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Partner</th>
                        <th class="px-4 py-3 text-left">Project</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Booking ID</th>
                        <th class="px-4 py-3 text-left">Unit</th>
                        <th class="px-4 py-3 text-left">Commission</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($commissions as $index => $commission)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">{{ $index + 1 }}</td>

                            <td class="px-4 py-3">
                                {{ $commission->partner->partner_name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $commission->project->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $commission->customer->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $commission->booking_id ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $commission->unit_name }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ amountToPoints($commission->total_amount) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('commissions.destroy', $commission->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs bg-red-100 text-red-600 rounded-md hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                No commission records found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</section>

@endsection