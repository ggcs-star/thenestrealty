<?php

namespace App\Http\Controllers;

use App\Models\ChannelPartner;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Collection;
use App\Models\Commission;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $employeeId = auth('employee')->id();
        $isEmployee = auth('employee')->check();

        if ($isEmployee) {
            $totalPartners = ChannelPartner::where('employee_id', $employeeId)->count();
            $totalProject = Project::where('assigned_employee', $employeeId)->count();
            $totalBooking = Booking::where('employee_id', $employeeId)->count();
            $totalCollection = Collection::where('employee_id', $employeeId)->count();
            $totalCommission = Commission::whereHas('booking', function ($q) use ($employeeId) {
                $q->where('employee_id', $employeeId);
            })->count();
            $totalEmployees = 1;

            $allFollowUps = Collection::with('booking')
                ->whereHas('booking', function ($q) use ($employeeId) {
                    $q->where('employee_id', $employeeId);
                })
                ->orderBy('date', 'desc')
                ->get();

            $projects = Project::where('assigned_employee', $employeeId)->get();
        } else {
            $totalPartners = ChannelPartner::count();
            $totalProject = Project::count();
            $totalBooking = Booking::count();
            $totalCollection = Collection::count();
            $totalCommission = Commission::count();
            $totalEmployees = Employee::count();

            $allFollowUps = Collection::with('booking')
                ->orderBy('date', 'desc')
                ->get();

            $projects = Project::all();
        }

        $todayFollowUps = $allFollowUps
            ->filter(fn($item) => Carbon::parse($item->date)->isSameDay($today))
            ->take(3);

        $historyFollowUps = $allFollowUps
            ->filter(fn($item) => Carbon::parse($item->date)->lt($today))
            ->take(3);

        $recentFollowUps = $allFollowUps
            ->filter(fn($item) => Carbon::parse($item->date)->gt($today))
            ->take(3);

        $completeFollowUps = $allFollowUps
            ->filter(fn($item) => $item->status === 'completed')
            ->take(3);

        $totalUnits = 0;
        $bookedUnits = 0;
        $availableUnits = 0;

        foreach ($projects as $project) {
            $totalUnits += count($project->units ?? []);
            $bookedUnits += count($project->booked_units ?? []);
            $availableUnits += count($project->available_units ?? []);
        }



        $availableUnitsTable = collect($projects)
            ->flatMap(function ($project) {
                return collect($project->available_units)->map(function ($unit) use ($project) {
                    return [
                        'unit_no' => $unit,
                        'tower' => $project->name ?? 'N/A',
                        'status' => 'Available'
                    ];
                });
            })
            ->take(5)
            ->values();

        $availableUnitsTable = collect($availableUnitsTable)->take(5);
        $bookedUnitsTable = collect($projects)
            ->flatMap(function ($project) {
                return collect($project->booked_units)->map(function ($unit) use ($project) {
                    return [
                        'unit_no' => $unit,
                        'tower' => $project->name ?? 'N/A',
                        'status' => 'Booked'
                    ];
                });
            })
            ->take(5)
            ->values();
        $bookedUnitsTable = collect($bookedUnitsTable)->take(5);


        if ($isEmployee) {
            $customers = \App\Models\Customer::where('employee_id', $employeeId)
                ->with(['bookings', 'collections'])
                ->get();
        } else {
            $customers = \App\Models\Customer::with(['bookings', 'collections'])->get();
        }

        $totalCustomers = $customers->count();
        $totalCustomerBookings = $customers->sum(fn($c) => $c->bookings->count());
        $totalCustomerPayments = $customers->sum(fn($c) => $c->collections->sum('amount'));

        $activeCustomers = $customers->filter(fn($c) => $c->bookings->count() > 0)->count();
        $inactiveCustomers = $totalCustomers - $activeCustomers;

        $customerBookingValue = $customers->map(function ($c) {
            return [
                'name' => $c->name,
                'total' => $c->bookings->sum('total_amount')
            ];
        })->take(5);

        $customerPayments = $customers->map(function ($c) {
            return [
                'name' => $c->name,
                'total' => $c->collections->sum('amount')
            ];
        })->take(5);

        $bookingReport = $customers->flatMap(function ($c) {
            return $c->bookings->map(function ($b) use ($c) {
                return [
                    'customer' => $c->name,
                    'booking_id' => $b->booking_id,
                    'unit' => $b->unit_name,
                    'amount' => $b->total_amount,
                    'status' => $b->status
                ];
            });
        })->take(5);

        $paymentReport = $customers->flatMap(function ($c) {
            return $c->collections->map(function ($col) use ($c) {
                return [
                    'customer' => $c->name,
                    'amount' => $col->amount,
                    'date' => $col->date ?? '-'
                ];
            });
        })->take(5);

        $receivableReport = $customers->map(function ($c) {
            $total = $c->bookings->sum('total_amount');
            $paid = $c->collections->sum('amount');

            return [
                'customer' => $c->name,
                'total' => $total,
                'paid' => $paid,
                'due' => $total - $paid
            ];
        })->take(5);


if ($isEmployee) {
    $cancelledBookings = Booking::where('employee_id', $employeeId)
        ->where('status', 'cancelled')
        ->with('project')
        ->latest()
        ->take(5)
        ->get();
} else {
    $cancelledBookings = Booking::where('status', 'cancelled')
        ->with('project')
        ->latest()
        ->take(5)
        ->get();
}

$cancellationUnitsTable = $cancelledBookings->map(function ($b) {
    return [
        'unit_no' => $b->unit_name,
        'project' => $b->project->name ?? 'N/A',
        'customer' => $b->customer->name ?? 'N/A',
        'date' => $b->booking_date ?? '-',
        'status' => 'Cancelled'
    ];
});
// dd($cancellationUnitsTable);
        return view('layouts.dashboard', compact(
            'totalPartners',
            'totalProject',
            'totalBooking',
            'totalCollection',
            'totalCommission',
            'totalEmployees',
            'todayFollowUps',
            'historyFollowUps',
            'recentFollowUps',
            'completeFollowUps',
            'totalUnits',
            'bookedUnits',
            'availableUnits',
            'availableUnitsTable',
            'bookedUnitsTable',
            'totalCustomers',
            'totalCustomerBookings',
            'totalCustomerPayments',
            'activeCustomers',
            'inactiveCustomers',
            'customerBookingValue',
            'customerPayments',
            'bookingReport',
            'paymentReport',
            'receivableReport',
            'cancellationUnitsTable'
        ));
    }
}