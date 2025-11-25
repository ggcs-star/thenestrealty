@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="w-min-screen p-4 mx-auto mt-10 w-min-screen bg-white">
    <header class="mb-6">
        <div class="flex justify-between">
        <h2 class="text-2xl font-semibold text-gray-800">Channel Partner List</h2>
            <form method="GET" action="{{ route('partner.list') }}" class="flex gap-2 items-center">
                <label for="from" class="text-sm font-medium text-gray-700">From:</label>
                <input type="date" id="from" name="from"
                    value="{{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('Y-m-d') : '' }}"
                    class="border border-gray-300 px-3 py-1 rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <label for="to" class="text-sm font-medium text-gray-700">To:</label>
                <input type="date" id="to" name="to"
                    value="{{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('Y-m-d') : '' }}"
                    class="border border-gray-300 px-3 py-1 rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Apply</button>

                @if(request('date') || request('from') || request('to'))
                    <a href="{{ route('partner.list') }}"
                        class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 ml-2">Clear</a>
                @endif
            </form>
            </div>
    </header>

    <div class="bg-white overflow-x-auto">
        <table class="w-full table-auto border text-sm text-gray-800">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Partner Name</th>
                    <th class="px-3 py-2 border">Contact</th>
                    <th class="px-3 py-2 border">Email</th>
                    <th class="px-3 py-2 border">DOB</th>
                    <th class="px-3 py-2 border">Aadhaar</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $index => $partner)
                    <tr>
                        <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">{{ $partner->partner_name }}</td>
                        <td class="px-3 py-2 border">{{ $partner->number_contact }}</td>
                        <td class="px-3 py-2 border">{{ $partner->mail_id }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($partner->date_of_birth)->format('d-m-Y') }}</td>
                        <td class="px-3 py-2 border">{{ $partner->aadhaar_card }}</td>
                        <td class="px-3 py-2 border">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                {{ $partner->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($partner->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 border text-center">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <a href="{{ route('partner.edit', $partner->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                    Edit
                                </a>

                                <form action="{{ route('partner.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                        Delete
                                    </button>
                                </form>

                                <form action="{{ route('partner.toggleStatus', $partner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium px-3 py-1 rounded transition">
                                        {{ $partner->status === 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
