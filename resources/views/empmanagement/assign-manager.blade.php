    @php
        $hideDashboard = true;
    @endphp

    @extends('layouts.app')

    @section('content')
    <div class="p-6">

        <h1 class="text-xl font-semibold mb-4">Assign Roles</h1>

        <!-- Designation Table -->
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">#</th>
                <th class="border px-4 py-2 text-left">Designation</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="border px-4 py-2">1</td>
                <td class="border px-4 py-2">Manager</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">2</td>
                <td class="border px-4 py-2">Employee</td>
            </tr>
        
        </tbody>
    </table>

        </div>

    </div>
    @endsection
