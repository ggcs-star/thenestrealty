<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ChannelPartner; // Make sure ChannelPartner model is imported
use App\Models\Employee;
class BookingController extends Controller
{
    /**
     * Show the create booking form (called when visiting /bookings/create).
     */
   public function create(): View
{
    $customers = collect();
    $projects = collect();

    if (auth('employee')->check()) {

        $user = auth('employee')->user();

        if ($user->isManager()) {

            $teamIds = Employee::where('manager_id', $user->id)
                ->pluck('id')
                ->push($user->id)
                ->toArray();

        } else {
            $teamIds = [$user->id];
        }

       
        $customers = Customer::whereIn('employee_id', $teamIds)->get();

        $projects = Project::whereIn('assigned_employee', $teamIds)->get();
    }

   
    else {

        $customers = Customer::all();
        $projects = Project::all();
    }


    $channelPartners = ChannelPartner::all();

    return view('booking.create', compact('customers', 'projects', 'channelPartners'));
}

    /**
     * Handle the booking creation form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all()); // Debugging line to check incoming data
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'project_id' => 'required|exists:projects,id',
            'referred_by' => 'required|exists:partners,id',
            'unit_name' => 'required|regex:/^[A-Z][A-Z0-9]?\s\d+$/',
            'unit_size' => 'nullable|numeric',
            'unit_unit' => 'required|in:Sq. Feet,Sq. Yard',
            'booking_date' => 'required|date',
            'followup_date' => 'date',
            'invoice_amount' => 'required|numeric',
            'other_amount' => 'nullable|numeric',
            'status' => 'required|in:Booked,Cancelled',
        ]);

        $validated['total_amount'] = $validated['invoice_amount'] + ($validated['other_amount'] ?? 0);

        if (auth('employee')->check()) {
            $validated['employee_id'] = auth('employee')->id();
        }

        $project = Project::findOrFail($validated['project_id']);

        $unitNumber = str_replace(' ', '', $validated['unit_name']);

        if (!$project->isUnitAvailable($unitNumber)) {
            return back()->withErrors(['unit_name' => 'This unit is already booked.'])->withInput();
        }

        $booking = Booking::create($validated);

        $project->bookUnit($unitNumber);

        return redirect()->route('bookings.create')->with('success', 'Booking created successfully and unit marked as booked.');
    }


    /**
     * Optional index method (if accessed from /bookings or /bookings/index).
     * Redirects to create OR loads view with same data.
     */
    public function index(Request $request): View
{
    if (auth('employee')->check()) {

        $user = auth('employee')->user();

        if ($user->isManager()) {

            $teamIds = Employee::where('manager_id', $user->id)
                ->pluck('id')
                ->push($user->id)
                ->toArray();

            $customers = Customer::whereIn('employee_id', $teamIds)->get();

            $projects = Project::whereIn('assigned_employee', $teamIds)->get();
        } else {

            $employeeId = $user->id;

            $customers = Customer::where('employee_id', $employeeId)->get();

            $projects = Project::where('assigned_employee', $employeeId)->get();
        }
    } else {

        $customers = Customer::all();
        $projects = Project::all();
    }

   
    $channelPartners = ChannelPartner::all();

    return view('booking.create', [
        'user' => $request->user(),
        'customers' => $customers,
        'projects' => $projects,
        'channelPartners' => $channelPartners,
    ]);
}


    /**
     * List all bookings.
     */
    //   public function list(Request $request): View
// {
//     $query = Booking::with(['customer', 'project', 'channelPartner']);

    //     $from = $request->input('from');
//     $to = $request->input('to');
//     $specificDate = $request->input('date');

    //     // Role-based filtering
//     if (auth('employee')->check()) {
//         $employeeId = auth('employee')->id();
//         $query->where('employee_id', $employeeId); // sirf employee ke records
//     }
//     // Admin ke liye no filter, sab records dikhenge

    //     // Date filters
//     if ($specificDate) {
//         $query->whereDate('followup_date', $specificDate);
//     }

    //     if ($from && $to) {
//         $query->whereBetween('followup_date', [$from, $to]);
//     } elseif ($from) {
//         $query->whereDate('followup_date', '>=', $from);
//     } elseif ($to) {
//         $query->whereDate('followup_date', '<=', $to);
//     }

    //     $bookings = $query->orderBy('followup_date', 'desc')->get();

    //     return view('booking.list', compact('bookings'));
// }

    public function list(Request $request): View
    {
        $query = Booking::with(['customer', 'project', 'channelPartner']);


        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {

                $teamIds = Employee::where('manager_id', $user->id)
                    ->pluck('id')
                    ->push($user->id)
                    ->toArray();

                $query->whereIn('employee_id', $teamIds);
            } else {
                $query->where('employee_id', $user->id);
            }
        }


        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_id', 'like', '%' . $request->search . '%')
                    ->orWhere('unit_name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('project', function ($q3) use ($request) {
                        $q3->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('booking_date', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('booking_date', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('booking_date', '<=', $request->to);
        }


        $bookings = $query->latest()->paginate(5);

        $statsQuery = Booking::query();

        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {
                $teamIds = Employee::where('manager_id', $user->id)
                    ->pluck('id')
                    ->push($user->id)
                    ->toArray();

                $statsQuery->whereIn('employee_id', $teamIds);
            } else {
                $statsQuery->where('employee_id', $user->id);
            }
        }

        $totalBookings = $statsQuery->count();
        $totalBooked = (clone $statsQuery)->where('status', 'Booked')->count();
        $totalPending = (clone $statsQuery)->where('status', 'Pending')->count();
        $totalRevenue = (clone $statsQuery)->sum('total_amount');

        return view('booking.list', compact(
            'bookings',
            'totalBookings',
            'totalBooked',
            'totalPending',
            'totalRevenue'
        ));
    }

   public function edit($id): View
{
    $booking = Booking::findOrFail($id);

    $customers = collect();
    $projects = collect();

    if (auth('employee')->check()) {

        $user = auth('employee')->user();

        if ($user->isManager()) {

            $teamIds = Employee::where('manager_id', $user->id)
                ->pluck('id')
                ->push($user->id)
                ->toArray();

            $customers = Customer::whereIn('employee_id', $teamIds)->get();

            $projects = Project::whereIn('assigned_employee', $teamIds)->get();
        } else {

            $employeeId = $user->id;

            $customers = Customer::where('employee_id', $employeeId)->get();

            $projects = Project::where('assigned_employee', $employeeId)->get();
        }
    } else {

        $customers = Customer::all();
        $projects = Project::all();
    }

    
    $channelPartners = ChannelPartner::all();

    return view('booking.edit', compact(
        'booking',
        'customers',
        'projects',
        'channelPartners'
    ));
}

    public function update(Request $request, $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'project_id' => 'required|exists:projects,id',
            // VALIDATION CHANGE: 'referred_by' now must exist in 'partners' table's 'id' column
            'referred_by' => 'required|exists:partners,id',
            'unit_name' => 'required|regex:/^[A-Z][A-Z0-9]?\s\d+$/',
            'unit_size' => 'required|numeric',
            'unit_unit' => 'required|in:Sq. Feet,Sq. Yard',
            'booking_date' => 'required|date',
            'followup_date' => 'required|date',
            'invoice_amount' => 'required|numeric',
            'other_amount' => 'nullable|numeric',
            'status' => 'required|in:Booked,Cancelled',
        ]);

        $validated['total_amount'] = $validated['invoice_amount'] + ($validated['other_amount'] ?? 0);

        // Get the project
        $project = Project::findOrFail($validated['project_id']);

        // Extract unit numbers
        $oldUnitNumber = str_replace(' ', '', $booking->unit_name);
        $newUnitNumber = str_replace(' ', '', $validated['unit_name']);

        // If unit changed, handle the booking/unbooking
        if ($oldUnitNumber !== $newUnitNumber) {
            // Unbook the old unit
            $project->unbookUnit($oldUnitNumber);

            // Check if new unit is available
            if (!$project->isUnitAvailable($newUnitNumber)) {
                return back()->withErrors(['unit_name' => 'This unit is already booked.'])->withInput();
            }

            // Book the new unit
            $project->bookUnit($newUnitNumber);
        }

        // If status changed from Booked to Cancelled, unbook the unit
        if ($booking->status === 'Booked' && $validated['status'] === 'Cancelled') {
            $project->unbookUnit($newUnitNumber);
        }

        // If status changed from Cancelled to Booked, book the unit
        if ($booking->status === 'Cancelled' && $validated['status'] === 'Booked') {
            if (!$project->isUnitAvailable($newUnitNumber)) {
                return back()->withErrors(['unit_name' => 'This unit is already booked.'])->withInput();
            }
            $project->bookUnit($newUnitNumber);
        }

        $booking->update($validated);

        return redirect()->route('bookings.list')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        // Unbook the unit if the booking was active
        if ($booking->status === 'Booked') {
            $project = $booking->project;
            $unitNumber = str_replace(' ', '', $booking->unit_name);
            $project->unbookUnit($unitNumber);
        }

        $booking->delete();
        return redirect()->route('bookings.list')->with('success', 'Booking deleted.');
    }
}