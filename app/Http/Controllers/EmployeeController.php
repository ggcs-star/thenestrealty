<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    // public function index(): View
    // {
    //     $employees = Employee::all();
    //     return view('empmanagement.index', compact('employees'));
    // }
public function index(Request $request): View
{
    $query = Employee::query();

    // 🔍 SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone_number', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $employees = $query->latest()->paginate(10);

    return view('empmanagement.index', compact('employees'));
}
   
    public function create()
{
    $managers = Employee::where('designation', 'Manager')->get();

    return view('empmanagement.create', compact('managers'));
}

    public function assignManager(): View
    {
        return view('empmanagement.assign-manager');
    }
    public function edit($id)
{
    $employee = Employee::findOrFail($id);

    $managers = Employee::where('designation', 'Manager')->get();

    return view('empmanagement.edit', compact('employee', 'managers'));
}

    public function store(Request $request): RedirectResponse
{
    $user = auth('employee')->user(); 
    $admin = auth()->user(); 

    $validated = $request->validate(
        [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:employees,email',
            'birthdate' => 'required|date',
            'designation' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'manager_id' => 'nullable|exists:employees,id', 
        ],
        [
            'name.required' => 'Please enter employee name.',
            'phone_number.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password and confirmation do not match.',
            'status.required' => 'Please select employee status.',
        ]
    );

    try {

        $lastEmployeeId = Employee::latest('id')->value('id') ?? 0;
        $validated['employee_code'] = 'emp' . ($lastEmployeeId + 1);

        $validated['password'] = Hash::make($validated['password']);

        
        if ($user && $user->isManager()) {
            $validated['manager_id'] = $user->id;
        }

        elseif ($admin) {
            $validated['manager_id'] = $request->manager_id;
        }

        elseif ($user && $user->isEmployee()) {
            return back()->with('error', 'You are not allowed to create employees.');
        }

      

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', '🎉 Employee has been created successfully!');
    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Something went wrong. Please try again later.');
    }
}

    public function toggleStatus($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->status = $employee->status === 'active' ? 'inactive' : 'active';
        $employee->save();

        return response()->json(['success' => true, 'status' => $employee->status]);
    }


   public function update(Request $request, $id)
{
    try {

        // Fetch only required columns (fast & secure)
        $employee = Employee::select('id','name','email','phone_number','birthdate','designation','status')
                            ->findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone_number'  => 'required|string|max:15',
            'email'         => 'required|email:rfc,dns|unique:employees,email,' . $employee->id,
            'birthdate'     => 'required|date',
            'designation'   => 'required|string|max:255',
            'status'        => 'required|in:active,inactive',
        ]);

        // Prepare only changed fields
        $updateData = [];
        foreach ($validated as $key => $value) {
            if ($employee->$key != $value) {
                $updateData[$key] = $value;
            }
        }

        // Optional password update
        if ($request->filled('password')) {

            $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);

            $updateData['password'] = Hash::make($request->password);
        }

        // Update only if data changed
        if (!empty($updateData)) {
            $employee->update($updateData);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully!');

    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => 'Something went wrong. Please try again.'])
            ->withInput();
    }
}

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

}
