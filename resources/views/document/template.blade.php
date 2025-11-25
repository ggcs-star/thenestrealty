@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')
@section('content')
    <section>
        <header>

        </header>
        <div class="p-10 font-serif leading-relaxed text-gray-800">
            <h1 class="text-2xl font-bold text-center mb-6 underline">Loan Agreement</h1>

            <p>Date: <span class="font-medium">May 1, 2025</span></p>
            <p>Customer: <span class="font-medium">John Doe</span></p>
            <p>Loan Amount: ₹<span class="font-medium">12,50,000</span></p>
            <p>Loan Term: <span class="font-medium">5 years</span></p>

            <div class="mt-6">
                <p>
                    This Loan Agreement is made between <span class="font-semibold">ABC Finance Pvt. Ltd.</span>
                    ("Lender") and <span class="font-semibold">John Doe</span> ("Borrower") regarding the loan of
                    ₹12,50,000 for a period of 5 years, at an annual interest rate of 9%.
                </p>

                <p class="mt-4">
                    The Borrower agrees to repay the loan amount in equal monthly installments, beginning from
                    the date of disbursal. The terms, penalties, and legal obligations are detailed below.
                </p>

                <ul class="list-disc ml-6 mt-4">
                    <li>Late payment incurs 2% penalty per month.</li>
                    <li>Pre-closure charges apply if closed before 2 years.</li>
                    <li>Loan is secured against booking: BK-00123 (Skyline Heights - Unit 101).</li>
                </ul>
            </div>

            <div class="mt-10">
                <p>Authorized Signatory: _____________________</p>
                <p class="mt-2">Borrower Signature: _____________________</p>
            </div>
        </div>





    </section>
@endsection
