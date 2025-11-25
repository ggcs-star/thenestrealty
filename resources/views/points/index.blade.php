@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <section class="max-w-lg mx-auto mt-8">
        <header class="mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                Point System Settings
            </h2>
        </header>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('point-settings.update') }}" 
              class="bg-white p-10 rounded-lg shadow-sm border border-gray-100">
            @csrf

            <div class="space-y-4">
                <!-- Rupees per Point -->
                <div>
                    <label for="rupee_per_point" class="block text-sm font-medium text-gray-700 mb-1">
                        1 Point = (Rupees)
                    </label>
                    <input name="rupee_per_point" type="number" step="0.01"
                           value="{{ old('rupee_per_point', $setting->rupee_per_point) }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('rupee_per_point')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </section>
@endsection