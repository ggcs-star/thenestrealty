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
    $commission = Commission::with(['partner','project','customer'])->findOrFail($id);

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
    $commission = Commission::with(['partner','project','customer'])->findOrFail($id);

    $pdf = Pdf::loadView('commission.invoice', compact('commission'));

    return $pdf->download('commission_invoice_'.$commission->id.'.pdf');
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

}
