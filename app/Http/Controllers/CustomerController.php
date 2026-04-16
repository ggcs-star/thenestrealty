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

    // public function list(Request $request): View
// {
//     if (auth('employee')->check()) {
//         // Agar employee login hai → sirf apne customers
//         $employeeId = auth('employee')->id();
//         $customers = Customer::with('collections')
//             ->where('employee_id', $employeeId)
//             ->get();
//     } else {
//         // Admin ya default guard → sabhi customers
//         $customers = Customer::with('collections')->get();
//     }

    //     return view('customer.list', compact('customers'));
// }

    public function list(Request $request): View
    {
        $query = Customer::with('collections');

        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {

                $query->where(function ($q) use ($user) {

                    $q->where('employee_id', $user->id)

                        ->orWhereIn('employee_id', function ($sub) use ($user) {
                            $sub->select('id')
                                ->from('employees')
                                ->where('manager_id', $user->id);
                        });
                });
            } else {
                $query->where('employee_id', $user->id);
            }
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('contact_number', 'like', '%' . $request->search . '%')
                    ->orWhere('aadhar_number', 'like', '%' . $request->search . '%')
                    ->orWhere('pan_number', 'like', '%' . $request->search . '%');
            });
        }


        $customers = $query->latest()->paginate(10);

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
        $user = auth('employee')->user();


        if ($user) {

            $teamIds = $user->isManager()
                ? Employee::where('manager_id', $user->id)
                    ->pluck('id')
                    ->push($user->id)
                    ->toArray()
                : [$user->id];

            $employees = Employee::whereIn('id', $teamIds)->get();

            $customers = Customer::whereIn('employee_id', $teamIds)->get();

            $partners = ChannelPartner::whereIn('employee_id', $teamIds)
                ->distinct()
                ->pluck('partner_name');

            $builders = Project::whereIn('assigned_employee', $teamIds)
                ->whereNotNull('builder_name')
                ->distinct()
                ->pluck('builder_name');

        } else {

            $employees = Employee::all();

            $customers = Customer::all();

            $partners = ChannelPartner::whereNotNull('partner_name')
                ->distinct()
                ->pluck('partner_name');

            $builders = Project::whereNotNull('builder_name')
                ->distinct()
                ->pluck('builder_name');
        }

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
        $customer->update($request->only('name', 'email', 'contact_number', 'referred_by', 'contact_number', 'dob', 'aadhar_number', 'pan_number'));

        return redirect()->route('customer.list')->with('success', 'Customer updated successfully!');
    }



    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
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
        $employeeId = auth('employee')->id();

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
            'employee_id' => $employeeId,
        ]);

        return redirect()->route('customer.list')->with('success', 'Customer created successfully!');
    }


}

