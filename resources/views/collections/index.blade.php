@php
    $hideDashboard = true;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payment Commitments</h2>
        <a href="{{ route('collections.create') }}" class="btn btn-primary">Add New Commitment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($collections->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Booking ID</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>A/C Transfer</th>
                                <th>A/C Date</th>
                                <th>Other Amount</th>
                                <th>Other Date</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                    <tbody>
    @foreach($collections as $index => $collection)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $collection->customer->name ?? 'N/A' }}</td>
            <td>{{ $collection->booking->booking_id ?? 'N/A' }}</td>
            <td>{{ $collection->loan_payment_amount ? '₹' . number_format($collection->loan_payment_amount, 2) : '-' }}</td>
            <td>{{ $collection->loan_payment_date ? $collection->loan_payment_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $collection->ac_transfer_amount ? '₹' . number_format($collection->ac_transfer_amount, 2) : '-' }}</td>
            <td>{{ $collection->ac_transfer_date ? $collection->ac_transfer_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $collection->other_mode_amount ? '₹' . number_format($collection->other_mode_amount, 2) : '-' }}</td>
            <td>{{ $collection->other_mode_date ? $collection->other_mode_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $collection->other_mode_description ?: '-' }}</td>
            <td>{{ $collection->status ?? '-' }}</td> <!-- ✅ Added Status Column -->
            <td>{{ $collection->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
</tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">No payment commitments found</h5>
                <p class="text-muted">Start by adding a new payment commitment.</p>
                <a href="{{ route('collections.create') }}" class="btn btn-primary">Add First Commitment</a>
            </div>
        </div>
    @endif
</div>
@endsection 