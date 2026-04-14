@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
<section class="px-6 py-6 w-full">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Employee Management</h2>
            <p class="text-sm text-gray-500">Manage all employees</p>
        </div>

        <a href="{{ route('employees.create') }}"
            class="px-4 py-2 text-sm bg-[#AC7E2C] text-white rounded-lg hover:bg-[#8C651F]">
            + Add Employee
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Employee</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">DOB</th>
                        <th class="px-4 py-3 text-left">Designation</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                    @forelse ($employees as $index => $emp)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- INDEX -->
                            <td class="px-4 py-3 text-gray-500">
                                {{ $employees->firstItem() + $index }}
                            </td>

                            <!-- NAME -->
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $emp->name }}
                            </td>

                            <!-- PHONE -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ $emp->phone_number }}
                            </td>

                            <!-- EMAIL -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ $emp->email }}
                            </td>

                            <!-- DOB -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($emp->birthdate)->format('d M Y') }}
                            </td>

                            <!-- DESIGNATION -->
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                    {{ $emp->designation }}
                                </span>
                            </td>

                            <!-- STATUS -->
                            <td class="px-4 py-3">
                                <button onclick="toggleStatus('{{ route('employees.toggleStatus', $emp->id) }}')"
                                    class="px-3 py-1 text-xs rounded-full font-medium
                                    {{ $emp->status == 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($emp->status) }}
                                </button>
                            </td>

                            <!-- ACTIONS -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('employees.edit', $emp->id) }}"
                                        class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded-lg hover:bg-[#8C651F]">
                                        Edit
                                    </a>

                                    <form action="{{ route('employees.destroy', $emp->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-400">
                                No employees found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $employees->withQueryString()->links() }}
    </div>

</section>

<!-- STATUS TOGGLE -->
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
        if (data.success) location.reload();
    })
    .catch(err => console.error(err));
}
</script>

@endsection