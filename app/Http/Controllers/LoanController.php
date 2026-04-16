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
        $query = Loan::with(['employee', 'stage', 'booking']);

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
        $baseQuery = Loan::query()
            ->with(['employee', 'stage', 'booking'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('customer_name', 'like', "%$search%")
                        ->orWhere('bank_name', 'like', "%$search%")
                        ->orWhere('unit_name', 'like', "%$search%");
                });
            })
            ->when($request->filled('stage'), function ($q) use ($request) {
                $q->where('loan_stage_id', $request->stage);
            })
            ->when($request->filled(['from_date', 'to_date']), function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            });

        // 1. Aggregated Data for the Tabs (Bank, Customer, Project)
        $bankWise = (clone $baseQuery)
            ->selectRaw('bank_name, COUNT(*) as total_cases, SUM(loan_amount) as total_amount')
            ->whereNotNull('bank_name')
            ->groupBy('bank_name')
            ->get();

        $customerWise = (clone $baseQuery)
            ->selectRaw('customer_name, COUNT(*) as total_cases, SUM(loan_amount) as total_amount')
            ->whereNotNull('customer_name')
            ->groupBy('customer_name')
            ->get();

        $projectWise = (clone $baseQuery)
            ->selectRaw('unit_name as project_name, COUNT(*) as total_cases, SUM(loan_amount) as total_amount')
            ->whereNotNull('unit_name')
            ->groupBy('unit_name')
            ->get();

        // 2. Top Summary Cards Data
        $totalLoans = (clone $baseQuery)->count();
        $totalAmount = (clone $baseQuery)->sum('loan_amount');
        $dynamicStages = \App\Models\LoanStage::count();

        // Assuming stages with 'Disbursed' or 'Closed' or 'Completed' denote finished pipelines
        $disbursedCases = (clone $baseQuery)->whereHas('stage', function($q) {
            $q->where('name', 'like', '%Disbursed%')
              ->orWhere('name', 'like', '%Closed%')
              ->orWhere('name', 'like', '%Completed%');
        })->count();

        // 3. Dropdown Options for Filters
        $banksList = Loan::select('bank_name')->whereNotNull('bank_name')->distinct()->pluck('bank_name');
        $customersList = Loan::select('customer_name')->whereNotNull('customer_name')->distinct()->pluck('customer_name');
        $employeesList = \App\Models\Employee::all();
        $stagesList = \App\Models\LoanStage::all();

        // 4. Detailed List Data (for the main table view)
        $loans = $baseQuery->latest()->paginate(10)->withQueryString();

        return view('reports.loan', compact(
            'loans',
            'totalLoans',
            'totalAmount',
            'dynamicStages',
            'disbursedCases',
            'bankWise',
            'customerWise',
            'projectWise',
            'banksList',
            'customersList',
            'employeesList',
            'stagesList'
        ));
    }
public function employeeLoans(Request $request, $employeeId)
{
    $query = Loan::with(['employee', 'stage'])
        ->where('employee_id', $employeeId)

        ->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($subQ) use ($search) {
                $subQ->where('customer_name', 'like', "%$search%")
                    ->orWhere('bank_name', 'like', "%$search%")
                    ->orWhere('unit_name', 'like', "%$search%");
            });
        })

        ->when($request->filled('stage'), function ($q) use ($request) {
            $q->where('loan_stage_id', $request->stage);
        })

        ->when($request->filled(['from_date', 'to_date']), function ($q) use ($request) {
            $q->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        });

    $loans = $query->latest()->paginate(10)->withQueryString();

    $employee = Employee::find($employeeId);

    return view('reports.employee-loans', compact('loans', 'employee'));
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