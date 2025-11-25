@php
    $hideDashboard = false;
@endphp

@extends('layouts.app')

@section('content')
<div class="w-min-screen p-2 mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <div class="p-6 bg-white rounded-xl shadow">

        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Create Commission</h2>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Fetch Form --}}
        <form method="POST" action="{{ route('commissions.fetch') }}" class="mb-8 space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
            @csrf
            <div class="w-full">
                <label for="booking_id_fetch" class="block text-sm font-medium text-gray-700">Enter Booking ID</label>
                <input type="text" name="booking_id" id="booking_id_fetch" required
                       value="{{ old('booking_id', request('booking_id')) }}"
                       placeholder="e.g., TNR0001"
                       class="w-full px-3 py-3 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300 @error('booking_id') border-red-500 @enderror">
                @error('booking_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mt-1 sm:w-auto">
                <button type="submit"
                        class="w-full sm:w-auto px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Fetch Booking
                </button>
            </div>
        </form>

        @if(isset($booking))
            <div class="mb-6 p-4 border border-blue-200 rounded-lg bg-blue-50">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">Fetched Booking Details:</h3>
                <p><strong>Booking ID:</strong> {{ $booking->booking_id }}</p>
                <p><strong>Customer:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
                <p><strong>Project:</strong> {{ $booking->project->name ?? 'N/A' }}</p>
                <p><strong>Referred By:</strong> {{ $booking->channelPartner->partner_name ?? 'N/A' }}</p>
                @if ($booking->channelPartner)
                    <p><strong>Partner Commission Rate:</strong> {{ $booking->channelPartner->commission ?? 'N/A' }}</p>
                @endif
                <p><strong>Unit Name:</strong> {{ $booking->unit_name }}</p>
                <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</p>
                <p><strong>Total Amount:</strong> ₹{{ number_format($booking->total_amount, 2) }}</p>
            </div>

            @php
                $suggestedCommissionAmount = '';
                if ($booking->total_amount && $booking->channelPartner && $booking->channelPartner->commission) {
                    $commissionRateString = preg_replace('/[^0-9.]/', '', $booking->channelPartner->commission);
                    $commissionRate = (float) $commissionRateString / 100;
                    $suggestedCommissionAmount = $booking->total_amount * $commissionRate;
                }
            @endphp

            {{-- Save Commission Form --}}
            <form method="POST" action="{{ route('commissions.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">
                <input type="hidden" name="partner_id" value="{{ $booking->referred_by }}">
                <input type="hidden" name="project_id" value="{{ $booking->project_id }}">
                <input type="hidden" name="customer_id" value="{{ $booking->customer_id }}">
                <input type="hidden" name="unit_name" value="{{ $booking->unit_name }}">
                <input type="hidden" name="total_amount" value="{{ $booking->total_amount }}">
                <input type="hidden" name="partner_commission_rate" value="{{ $booking->channelPartner->commission }}">

                <div>
                    <label for="booking_total_amount_display" class="block text-sm font-medium text-gray-700">Booking Total Amount</label>
                    <input type="text" id="booking_total_amount_display" value="₹{{ number_format($booking->total_amount, 2) }}" readonly
                           class="w-full px-3 py-2 mt-1 bg-gray-100 border border-gray-300 rounded shadow-sm cursor-not-allowed">
                </div>

                <div>
                    <label for="calculated_commission_display" class="block text-sm font-medium text-gray-700">Calculated Commission</label>
                    <input type="text" id="calculated_commission_display"
                           value="₹{{ number_format($suggestedCommissionAmount, 2) }}"
                           readonly
                           class="w-full px-3 py-2 mt-1 bg-gray-100 border border-gray-300 rounded shadow-sm cursor-not-allowed">
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Commission Amount (Editable)</label>
                    <input type="number" name="amount" id="amount" required step="0.01"
                           value="{{ old('amount', number_format($suggestedCommissionAmount, 2, '.', '')) }}"
                           class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300 @error('amount') border-red-500 @enderror">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        {{ $booking->commission ? 'Update Commission' : 'Save Commission' }}
                    </button>
                </div>
            </form>
        @endif

    </div>
</div>
@endsection
