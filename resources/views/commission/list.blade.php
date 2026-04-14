@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-full max-w-screen-xl mx-auto p-6 bg-white shadow rounded-xl mt-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Commission Management</h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 border border-green-300 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-200 text-sm text-gray-800">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-3 py-2 border border-gray-200 text-left">#</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Partner Name</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Project Name</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Customer Name</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Booking ID</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Unit Name</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Payment Status</th>
                        <th class="px-3 py-2 border border-gray-200 text-left">Commission Amount</th>
                        <th class="px-3 py-2 border border-gray-200 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $index => $commission)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 py-2 border border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $commission->partner->partner_name ?? '-' }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $commission->project->name ?? '-' }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $commission->customer->name ?? '-' }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $commission->booking_id ?? '-' }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $commission->unit_name }}</td>
                            <td class="px-3 py-2 border border-gray-200">
                                <form method="POST" action="{{ route('commissions.status.update', $commission->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select 
                                        name="payment_status" 
                                        onchange="this.form.submit()" 
                                        class="text-xs px-3 py-1.5 rounded-md border font-medium focus:outline-none focus:ring-1
                                        {{ $commission->payment_status === 'confirmed' 
                                            ? 'bg-green-50 text-green-700 border-green-300 focus:ring-green-400' 
                                            : 'bg-yellow-50 text-yellow-700 border-yellow-300 focus:ring-yellow-400' }}">
                                        <option value="pending" {{ $commission->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $commission->payment_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-3 py-2 border border-gray-200">{{ amountToPoints($commission->total_amount) }}</td>
                            <td class="px-3 py-2 border border-gray-200">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('commissions.show', $commission->id) }}" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded inline-block">
                                        View
                                    </a>
                                    <form action="{{ route('commissions.destroy', $commission->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this commission?')"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500 border border-gray-200">No commission records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection