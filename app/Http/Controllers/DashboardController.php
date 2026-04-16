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
use App\Models\Customer;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth('employee')->user();
        $today = Carbon::today();

        $teamIds = [];

        if ($user) {
            $teamIds = $user->isManager()
                ? Employee::where('manager_id', $user->id)
                    ->pluck('id')
                    ->push($user->id)
                    ->toArray()
                : [$user->id];

        }

        $projectQuery = Project::query();
        $bookingQuery = Booking::query();
        $collectionQuery = Collection::query();

        if ($user) {
            $projectQuery->whereIn('assigned_employee', $teamIds);
            $bookingQuery->whereIn('employee_id', $teamIds);
            $collectionQuery->whereIn('employee_id', $teamIds);
        }


        $totalPartners = $user
            ? ChannelPartner::whereIn('employee_id', $teamIds)->count()
            : ChannelPartner::count();

        $totalProject = $projectQuery->count();
        $totalBooking = $bookingQuery->count();
        $totalCollection = $collectionQuery->count();

        $totalCommission = Commission::whereHas('booking', function ($q) use ($user, $teamIds) {
            if ($user) {
                $q->whereIn('employee_id', $teamIds);
            }
        })->count();

        $totalEmployees = $user ? count($teamIds) : Employee::count();


        $allFollowUps = $collectionQuery->with('booking')->latest('date')->get();

        $todayFollowUps = $allFollowUps->where('date', $today)->take(3);
        $historyFollowUps = $allFollowUps->where('date', '<', $today)->take(3);
        $recentFollowUps = $allFollowUps->take(3);
        $completeFollowUps = $allFollowUps->where('status', 'completed')->take(3);


        $projects = $projectQuery->get();

        $totalUnits = $projects->sum(fn($p) => count($p->units ?? []));
        $bookedUnits = $projects->sum(fn($p) => count($p->booked_units ?? []));
        $availableUnits = $projects->sum(fn($p) => count($p->available_units ?? []));

        $availableUnitsTable = $projects
            ->sortByDesc('created_at')
            ->flatMap(function ($p) {
                $unitSizes = $p->unit_sizes ?? [];

                return collect($p->available_units)->map(function ($unit) use ($p, $unitSizes) {
                    return [
                        'unit_no' => $unit,
                        'tower' => $p->name ?? 'N/A',
                        'size' => $unitSizes[$unit] ?? 'N/A',
                        'status' => 'Available'
                    ];
                });
            })
            ->take(5)
            ->values();

        $bookedUnitsTable = Booking::with(['customer', 'project'])
            ->when($user, fn($q) => $q->whereIn('employee_id', $teamIds))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($b) => [
                'unit_no' => $b->unit_name,
                'tower' => $b->project->name ?? 'N/A',
                'customer' => $b->customer->name ?? 'N/A',
                'booking_id' => $b->booking_id ?? 'N/A',
                'size' => ($b->unit_size && $b->unit_unit)
                    ? $b->unit_size . ' ' . $b->unit_unit
                    : 'N/A',
                'status' => 'Booked'
            ]);


        $customers = $user
            ? Customer::whereIn('employee_id', $teamIds)
                ->with(['bookings', 'collections'])
                ->latest()
                ->get()
            : Customer::with(['bookings', 'collections'])->latest()->get();

        $totalCustomers = $customers->count();
        $totalCustomerBookings = $customers->sum(fn($c) => $c->bookings->count());
        $totalCustomerPayments = $customers->sum(fn($c) => $c->collections->sum('amount'));

        $activeCustomers = $customers->filter(fn($c) => $c->bookings->count() > 0)->count();
        $inactiveCustomers = $totalCustomers - $activeCustomers;


        $bookingReport = Booking::with('customer')
            ->when($user, fn($q) => $q->whereIn('employee_id', $teamIds))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($b) => [
                'customer' => $b->customer->name ?? 'N/A',
                'booking_id' => $b->booking_id,
                'unit' => $b->unit_name,
                'amount' => $b->total_amount,
                'status' => $b->status
            ]);

        $paymentReport = Collection::with('customer')
            ->when($user, fn($q) => $q->whereIn('employee_id', $teamIds))
            ->latest('date')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'customer' => $c->customer->name ?? 'N/A',
                'amount' => $c->amount,
                'date' => $c->date
            ]);

        $receivableReport = $customers->map(function ($c) {
            $total = $c->bookings->sum('total_amount');
            $paid = $c->collections->sum('amount');

            return [
                'customer' => $c->name,
                'total' => $total,
                'paid' => $paid,
                'due' => $total - $paid
            ];
        })->sortByDesc('due')->take(5);

        $cancellationUnitsTable = Booking::with(['project', 'customer'])
            ->when($user, fn($q) => $q->whereIn('employee_id', $teamIds))
            ->where('status', 'cancelled')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($b) => [
                'unit_no' => $b->unit_name,
                'project' => $b->project->name ?? 'N/A',
                'customer' => $b->customer->name ?? 'N/A',
                'date' => $b->booking_date,
                'status' => 'Cancelled'
            ]);

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
            'bookingReport',
            'paymentReport',
            'receivableReport',
            'cancellationUnitsTable'
        ));
    }
}