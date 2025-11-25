@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-min-screen p-10 mx-auto mt-10 p-6 bg-white shadow rounded">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Employee List</h2>
        </div>

        <table class="w-full table-auto border text-sm text-center">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Employee Name</th>
                    <th class="px-3 py-2 border">Number</th>
                    <th class="px-3 py-2 border">Mail ID</th>
                    <th class="px-3 py-2 border">D.O.B.</th>
                    <th class="px-3 py-2 border">Designation</th>
                    <th class="px-3 py-2 border">Password</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $index => $emp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">{{ $emp->name }}</td>
                        <td class="px-3 py-2 border">{{ $emp->phone_number }}</td>
                        <td class="px-3 py-2 border">{{ $emp->email }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($emp->birthdate)->format('d-m-Y') }}</td>
                        <td class="px-3 py-2 border">{{ $emp->designation }}</td>
                        <td class="px-3 py-2 border text-gray-400 italic">Hidden</td> {{-- Password intentionally hidden --}}
                        <td class="px-3 py-2 border">
                            <button onclick="toggleStatus('{{ route('employees.toggleStatus', $emp->id) }}')" class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $emp->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($emp->status) }}
                            </button>

                        </td>

                        <td class="px-3 py-2 border text-center">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <a href="{{ route('employees.edit', $emp->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                    Edit
                                </a>

                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded transition">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-3 py-4 text-center text-gray-500">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        function toggleStatus(url) {
            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(err => console.error(err));
        }

    </script>
@endsection