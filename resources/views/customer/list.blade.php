@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-4 mx-auto mt-10 rounded-xl bg-white ">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Customer List</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-auto bg-white">
        <table class="w-full table-auto border text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-3 py-2 border">Name</th>
                    <th class="px-3 py-2 border">Email</th>
                    <th class="px-3 py-2 border">Contact</th>
                    <th class="px-3 py-2 border">Aadhaar No.</th>
                    <th class="px-3 py-2 border">PAN No.</th>
                    <th class="px-3 py-2 border">Referred By</th>
                    <th class="px-3 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="px-3 py-2 border">{{ $customer->name }}</td>
                        <td class="px-3 py-2 border">{{ $customer->email }}</td>
                        <td class="px-3 py-2 border">{{ $customer->contact_number }}</td>
                        <td class="px-3 py-2 border">{{ $customer->aadhar_number }}</td>
                        <td class="px-3 py-2 border">{{ $customer->pan_number }}</td>
                        <td class="px-3 py-2 border">{{ ucfirst(str_replace('_', ' ', $customer->referred_by)) }}</td>
                        <td class="px-3 py-2 border text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this customer?')"
                                            class="text-red-600 hover:text-red-800 font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 border">
                            No customers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
