<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Loan;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Employee;

class LoanController extends Controller
{
    public function index()
    {
        if (auth('employee')->check()) {
            $employeeId = auth('employee')->id();

            // Employee ke liye sirf uske records
            $customers = Customer::where('employee_id', $employeeId)->get();
            $Booking = Booking::where('employee_id', $employeeId)->get();
            $Emp = Employee::where('id', $employeeId)->get(); // sirf uska record
        } else {
            // Admin ke liye sabhi records
            $customers = Customer::all();
            $Booking = Booking::all();
            $Emp = Employee::all();
        }

        $loans = Loan::all();

        return view('loan.create', compact('loans', 'Booking', 'customers', 'Emp'));
    }



    public function store(Request $request)
    {
        \Log::info('Received form data:', $request->all());

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'required|exists:bookings,id',
            'bank_name' => 'nullable|string',
            'loan_amount' => 'required|numeric',
            'loan_stage' => 'nullable|string',
            'notes' => 'nullable|string',

            'employee_name' => auth('employee')->check() ? 'nullable' : 'required|exists:employees,id',
            'employee_number' => auth('employee')->check() ? 'nullable' : 'required|string',
        ]);

        $customer = Customer::find($request->customer_id);
        $booking = Booking::find($request->booking_id);

        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            $employeeId = $employee->id;
            $employeeName = $employee->name;
            $employeeNumber = $employee->phone_number ?? null;
        } else {
            $employee = Employee::find($request->employee_name);
            $employeeId = $employee->id ?? null;
            $employeeName = $employee->name ?? null;
            $employeeNumber = $employee->phone_number ?? $request->employee_number;
        }


        $loan = Loan::create([
            'customer_name' => $customer->name ?? 'Unknown',
            'booking_id' => $booking->id,
            'unit_name' => $booking->unit_name ?? 'Default Display',
            'bank_name' => $request->bank_name,
            'employee_id' => $employeeId,
            'employee_name' => $employeeName,
            'employee_number' => $employeeNumber,
            'loan_amount' => $request->loan_amount,
            'loan_stage' => $request->loan_stage,
            'notes' => $request->notes,
        ]);

        \Log::info("Created loan:", $loan->toArray());

        return redirect()->back()->with('success', 'Loan entry saved successfully.');
    }



//    public function list()
// {
//     if (auth('employee')->check()) {
//         // employee login -> sirf apna data
//         $employeeId = auth('employee')->id();
//         $loans = Loan::where('employee_id', $employeeId)->get();
//     } else {
//         // admin login -> sabhi data
//         $loans = Loan::all();
//     }

//     return view('loan.list', compact('loans'));
// }

public function list(Request $request)
{
    $query = Loan::query();

    // 🔍 SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('customer_name', 'like', '%' . $request->search . '%')
              ->orWhere('booking_id', 'like', '%' . $request->search . '%')
              ->orWhere('unit_name', 'like', '%' . $request->search . '%')
              ->orWhere('bank_name', 'like', '%' . $request->search . '%');
        });
    }

    // 🎯 STAGE FILTER
    if ($request->filled('stage')) {
        $query->where('loan_stage', $request->stage);
    }

    // 📄 PAGINATION
    $loans = $query->latest()->paginate(10);

    return view('loan.list', compact('loans'));
}
}
;