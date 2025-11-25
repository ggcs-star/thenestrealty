@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
<div class="w-min-screen mx-auto p-6 bg-white shadow rounded-xl mt-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Commission Management</h2>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 border border-green-300 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full table-auto border text-sm text-gray-800">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Partner Name</th>
                    <th class="px-3 py-2 border">Project Name</th>
                    <th class="px-3 py-2 border">Customer Name</th>
                    <th class="px-3 py-2 border">Booking ID</th>
                    <th class="px-3 py-2 border">Unit Name</th>
                    <th class="px-3 py-2 border">Commission Amount</th>
                    <th class="px-3 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $index => $commission)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-3 py-2 border">{{ $commission->partner->partner_name ?? '-' }}</td>
                    <td class="px-3 py-2 border">{{ $commission->project->name ?? '-' }}</td>
                    <td class="px-3 py-2 border">{{ $commission->customer->name ?? '-' }}</td>
                    <td class="px-3 py-2 border">{{ $commission->booking_id ?? '-' }}</td>
                    <td class="px-3 py-2 border">{{ $commission->unit_name }}</td>
                    <td class="px-3 py-2 border">{{ amountToPoints($commission->total_amount) }}</td>
                    <td class="px-3 py-2 border text-center">
                        <div class="flex justify-center gap-2 flex-wrap">
                            {{-- Uncomment if status toggle is needed
                            @if($commission->status === 'Unpaid')
                                <form action="{{ route('commissions.markAsPaid', $commission->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1 rounded">
                                        Mark as Paid
                                    </button>
                                </form>
                            @endif
                            --}}

                            <form action="{{ route('commissions.destroy', $commission->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No commission records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
