<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Models\ChannelPartner;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Commission;
use Barryvdh\DomPDF\Facade\Pdf;

class CommissionController extends Controller
{
    // Show list of commissions
    public function list(Request $request): View
    {
        $commissions = Commission::with(['partner', 'project', 'customer', 'booking'])->get();

        return view('commission.list', [
            'commissions' => $commissions,
            'user' => $request->user()
        ]);
    }
    public function show($id)
    {
        $commission = Commission::with([
            'partner',
            'project',
            'customer',
            'booking'
        ])->findOrFail($id);

        return view('commission.show', compact('commission'));
    }

    public function invoice($id)
    {
        $commission = Commission::with(['partner', 'project', 'customer'])->findOrFail($id);

        return view('commission.invoice', compact('commission'));
    }
    public function updateStatus(Request $request, $id)
    {
        $commission = Commission::findOrFail($id);

        $commission->payment_status = $request->payment_status;
        $commission->save();

        return back()->with('success', 'Status updated successfully');
    }


    public function download($id)
    {
        $commission = Commission::with(['partner', 'project', 'customer'])->findOrFail($id);

        $pdf = Pdf::loadView('commission.invoice', compact('commission'));

        return $pdf->download('commission_invoice_' . $commission->id . '.pdf');
    }

    public function create(Request $request): \Illuminate\View\View
    {
        $booking = session('booking');

        $bookings = \App\Models\Booking::select('id', 'booking_id')->get();

        return view('commission.create', compact('booking', 'bookings'));
    }

    public function fetch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'booking_id' => 'required|string|exists:bookings,booking_id',
        ]);

        $booking = Booking::with(['project', 'customer', 'channelPartner'])
            ->where('booking_id', $request->booking_id)
            ->first();

        if (!$booking) {
            return redirect()->route('commissions.create')->withErrors([
                'booking_id' => 'Booking not found with the provided ID.'
            ]);
        }

        // Pass booking_id in URL and full object in session (flash)
        return redirect()
            ->route('commissions.create', ['booking_id' => $booking->booking_id])
            ->with('booking', $booking);
    }

    // Store commission in DB
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'project_id' => 'required|exists:projects,id',
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'required|string|exists:bookings,booking_id',
            'unit_name' => 'required|string',
            'partner_commission_rate' => 'required|string',
            'amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|in:pending,confirmed'
        ]);


        Commission::create($validated);

        return redirect()->route('commissions.create')->with('success', 'Commission Saved!');
    }

    // Mark as Paid
    // public function markAsPaid($id): RedirectResponse
    // {
    //     $commission = Commission::findOrFail($id);
    //     if ($commission->status !== 'Paid') {
    //         $commission->status = 'Paid';
    //         $commission->save();
    //     }
    //     return back()->with('success', 'Commission marked as paid.');
    // }

    // Delete commission
    public function destroy($id): RedirectResponse
    {
        Commission::findOrFail($id)->delete();
        return back()->with('success', 'Commission deleted.');
    }

    public function index()
    {
        return redirect()->route('commissions.create');
    }



    public function report(Request $request)
    {
        $query = Commission::with(['partner', 'project', 'customer', 'booking']);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->whereHas('partner', function ($q) use ($search) {
                    $q->where('partner_name', 'like', "%{$search}%");
                })

                    ->orWhereHas('project', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    ->orWhere('unit_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('partner_id')) {
            $query->where('partner_id', $request->partner_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $query->latest();

        $commissions = $query->get();

        $grouped = $commissions->groupBy('partner_id')->map(function ($partnerData) {

            $projects = $partnerData->groupBy('project_id')->map(function ($projectData) {
                return [
                    'project' => $projectData->first()->project,
                    'total' => $projectData->sum('amount'),
                    'paid' => $projectData->where('payment_status', 'confirmed')->sum('amount'),
                    'pending' => $projectData->where('payment_status', 'pending')->sum('amount'),
                    'items' => $projectData
                ];
            })->values();

            return [
                'partner' => $partnerData->first()->partner,
                'total' => $partnerData->sum('amount'),
                'paid' => $partnerData->where('payment_status', 'confirmed')->sum('amount'),
                'pending' => $partnerData->where('payment_status', 'pending')->sum('amount'),
                'items_count' => $partnerData->count(),
                'projects' => $projects
            ];
        })->values();

        $totalCommission = $commissions->sum('amount');
        $totalPartners = $grouped->count();
        $paid = $commissions->where('payment_status', 'confirmed')->sum('amount');
        $pending = $commissions->where('payment_status', 'pending')->sum('amount');

        return view('reports.commission', compact(
            'grouped',
            'totalCommission',
            'totalPartners',
            'paid',
            'pending'
        ));
    }

    public function partnerReport($id)
    {
        $commissions = Commission::with([
            'partner:id,partner_name',
            'project:id,name',
            'customer:id,name',
            'booking:id' 
        ])
            ->where('partner_id', $id)
            ->latest()
            ->get();

        if ($commissions->isEmpty()) {
            return back()->with('error', 'No data found');
        }

        $partner = $commissions->first()->partner;

        $projects = $commissions->groupBy('project_id')->map(function ($projectData) {

            return [
                'project_name' => $projectData->first()->project->name ?? 'N/A',

                'total' => $projectData->sum('amount'),
                'paid' => $projectData->where('payment_status', 'confirmed')->sum('amount'),
                'pending' => $projectData->where('payment_status', 'pending')->sum('amount'),

                'bookings' => $projectData->map(function ($item) {
                    return [
                        'booking_id' => $item->booking_id ?? 'N/A',
                        'customer' => $item->customer->name ?? 'N/A',
                        'unit' => $item->unit_name,

                        'total_amount' => $item->total_amount,
                        'commission_rate' => $item->partner_commission_rate,
                        'amount' => $item->amount,

                        'status' => $item->payment_status,
                        'date' => $item->created_at->format('d M Y'),
                    ];
                })->values()

            ];
        })->values();

        $total = $commissions->sum('amount');
        $paid = $commissions->where('payment_status', 'confirmed')->sum('amount');
        $pending = $commissions->where('payment_status', 'pending')->sum('amount');

        return view('reports.partner_commission', compact(
            'partner',
            'projects',
            'total',
            'paid',
            'pending'
        ));
    }

}
