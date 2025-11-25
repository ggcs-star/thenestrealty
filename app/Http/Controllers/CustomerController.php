<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Models\Employee;
use App\Models\ChannelPartner;


class CustomerController extends Controller
{

public function list(Request $request): View
{
    if (auth('employee')->check()) {
        // Agar employee login hai → sirf apne customers
        $employeeId = auth('employee')->id();
        $customers = Customer::with('collections')
            ->where('employee_id', $employeeId)
            ->get();
    } else {
        // Admin ya default guard → sabhi customers
        $customers = Customer::with('collections')->get();
    }

    return view('customer.list', compact('customers'));
}





    public function create()
{
    $builders = Project::whereNotNull('builder_name')->distinct()->pluck('builder_name');
    $partners = ChannelPartner::whereNotNull('partner_name')->distinct()->pluck('partner_name');

    $employees = [];
    if (!auth('employee')->check()) {
        $employees = Employee::all();
    }

    return view('customer.create', compact('builders', 'employees', 'partners'));
}


    public function index()
    {
        $builders = Project::whereNotNull('builder_name')->distinct()->pluck('builder_name');
        $employees = Employee::all();
        $partners = ChannelPartner::whereNotNull('partner_name')->distinct()->pluck('partner_name');
        $customers = Customer::all();
        return view('customer.create', compact('builders', 'employees', 'partners', 'customers'));
    }
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }
    public function destroy($id)
        {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return redirect()->route('customer.list')->with('success', 'Customer deleted successfully!');
        }

    public function update(Request $request, $id)
{
    $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email',
            'dob' => 'required|date',
            'aadhar_number' => 'required|string|size:12',
            'pan_number' => 'required|string|size:10',
            'referred_by' => 'required|in:via_builder,via_partner',
            'builder_name' => 'nullable|required_if:referred_by,via_builder|string',
            'partner_name' => 'nullable|required_if:referred_by,via_partner|string',
    ]);

    $customer = Customer::findOrFail($id);
    $customer->update($request->only('name', 'email', 'contact_number', 'referred_by','contact_number','dob','aadhar_number','pan_number'));

    return redirect()->route('customer.list')->with('success', 'Customer updated successfully!');
}



    public function store(Request $request): RedirectResponse
{
   
    // Validate input
    $validated = $request->validate([
      'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|unique:customers,email',
            'dob' => 'required|date',
            'aadhar_number' => 'required|string|size:12',
            'pan_number' => 'required|string|size:10',
            'referred_by' => 'required|in:via_builder,via_partner',
            'builder_name' => 'nullable|required_if:referred_by,via_builder|string',
            'partner_name' => 'nullable|required_if:referred_by,via_partner|string',
    ]);
// dd($validated);
    // Get logged-in employee id
    $employeeId = auth('employee')->id();

 
    // Create customer
    Customer::create([
        'name' => $validated['name'],
        'contact_number' => $validated['contact_number'],
        'email' => $validated['email'],
        'dob' => $validated['dob'],
        'aadhar_number' => $validated['aadhar_number'],
        'pan_number' => $validated['pan_number'],
        'referred_by' => $validated['referred_by'],
        'builder_name' => $validated['builder_name'] ?? null,
        'partner_name' => $validated['partner_name'] ?? null,
        'employee_id' => $employeeId, // ✅ assign logged-in employee
    ]);

    return redirect()->route('customer.list')->with('success', 'Customer created successfully!');
}

    


}

