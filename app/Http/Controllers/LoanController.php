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
use App\Models\LoanStage;
class LoanController extends Controller
{
    public function index()
    {
        if (auth('employee')->check()) {
            $employeeId = auth('employee')->id();

            $customers = Customer::where('employee_id', $employeeId)->get();
            $Booking = Booking::where('employee_id', $employeeId)->get();
            $Emp = Employee::where('id', $employeeId)->get();
        } else {
            $customers = Customer::all();
            $Booking = Booking::all();
            $Emp = Employee::all();
        }

        $loans = Loan::with(['employee', 'stage'])->latest()->get();

        $stages = LoanStage::all();

        return view('loan.create', compact(
            'loans',
            'Booking',
            'customers',
            'Emp',
            'stages'
        ));
    }



    public function store(Request $request)
    {
        \Log::info('Received form data:', $request->all());

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'required|exists:bookings,id',
            'bank_name' => 'nullable|string',
            'loan_amount' => 'required|numeric',

            'loan_stage_id' => 'required|exists:loan_stages,id',

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

            'loan_stage_id' => $request->loan_stage_id,

            'notes' => $request->notes,
        ]);

        \Log::info("Created loan:", $loan->toArray());

        return redirect()->route('loan.list')->with('success', 'Loan entry saved successfully.');
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
    $query = Loan::with(['employee', 'stage','booking']);

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('customer_name', 'like', '%' . $request->search . '%')
              ->orWhere('booking_id', 'like', '%' . $request->search . '%')
              ->orWhere('unit_name', 'like', '%' . $request->search . '%')
              ->orWhere('bank_name', 'like', '%' . $request->search . '%');
        });
    }
    if ($request->filled('stage')) {
        $query->where('loan_stage_id', $request->stage);
    }

    $loans = $query->latest()->paginate(10);

    $stages = \App\Models\LoanStage::all();

    return view('loan.list', compact('loans', 'stages'));
}
public function edit($id)
{
    $loan = Loan::findOrFail($id);

    $customers = Customer::all();
    $Booking = Booking::all();
    $Emp = Employee::all();
    $stages = LoanStage::all();

    return view('loan.edit', compact(
        'loan',
        'customers',
        'Booking',
        'Emp',
        'stages'
    ));
}
public function update(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'booking_id' => 'required|exists:bookings,id',
        'bank_name' => 'nullable|string',
        'loan_amount' => 'required|numeric',
        'loan_stage_id' => 'required|exists:loan_stages,id',
        'notes' => 'nullable|string',
    ]);

    $customer = Customer::find($request->customer_id);
    $booking = Booking::find($request->booking_id);

    $loan->update([
        'customer_name' => $customer->name ?? 'Unknown',
        'booking_id' => $booking->id,
        'unit_name' => $booking->unit_name ?? 'Default Display',
        'bank_name' => $request->bank_name,
        'loan_amount' => $request->loan_amount,
        'loan_stage_id' => $request->loan_stage_id,
        'notes' => $request->notes,
    ]);

    return redirect()->route('loan.list')->with('success', 'Loan updated successfully');
}
    public function reports(Request $request)
    {
        $query = Loan::with('employee')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('customer_name', 'like', "%$search%")
                        ->orWhere('bank_name', 'like', "%$search%")
                        ->orWhere('unit_name', 'like', "%$search%");
                });
            })
            ->when($request->filled('stage'), function ($q) use ($request) {
                $q->where('loan_stage', $request->stage);
            })
            ->when($request->filled(['from_date', 'to_date']), function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
            });

        $filteredQuery = clone $query;

        $loans = $query->latest()->paginate(10);

        $total = $filteredQuery->count();
        $approved = (clone $filteredQuery)->where('loan_stage', 'approved')->count();
        $pending = (clone $filteredQuery)->where('loan_stage', 'pending')->count();
        $rejected = (clone $filteredQuery)->where('loan_stage', 'rejected')->count();

        return view('reports.loan', compact('loans', 'total', 'approved', 'pending', 'rejected'));
    }

    public function updateStage(Request $request, $id)
{
    $request->validate([
        'loan_stage_id' => 'required|exists:loan_stages,id'
    ]);

    $loan = Loan::findOrFail($id);

    $loan->update([
        'loan_stage_id' => $request->loan_stage_id
    ]);

    return back()->with('success', 'Stage updated successfully');
}
}



;