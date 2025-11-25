<?php

namespace App\Http\Controllers;

use App\Models\ChannelPartner;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class ChannelPartnerController extends Controller
{
    /**
     * Display a listing of the channel partners with optional date filtering.
     */
    public function list(Request $request): View
    {
       $query = ChannelPartner::query();

    // Apply date filters if present
    if ($request->filled('from') && $request->filled('to')) {
        $from = Carbon::parse($request->from)->startOfDay();
        $to = Carbon::parse($request->to)->endOfDay();
        $query->whereBetween('created_at', [$from, $to]);
    } elseif ($request->filled('from')) {
        $from = Carbon::parse($request->from)->startOfDay();
        $query->where('created_at', '>=', $from);
    } elseif ($request->filled('to')) {
        $to = Carbon::parse($request->to)->endOfDay();
        $query->where('created_at', '<=', $to);
    }

    // Apply employee filter
    if (auth('employee')->check()) {
        $employeeId = auth('employee')->id();
        $query->where('employee_id', $employeeId); // Only this employee's records
    }

    // Admin (default guard) gets all records
    $partners = $query->orderBy('created_at', 'desc')->get();

    return view('partner.list', compact('partners'));
    }

    /**
     * Show the form to create a new channel partner.
     */
    public function create(): View
    {
        return view('partner.create');
    }

    /**
     * Store a newly created channel partner in the database.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'partner_name'   => 'required|string|max:255',
        'number_contact' => 'required|string|max:20',
        'mail_id'        => 'required|email|unique:partners,mail_id',
        'date_of_birth'  => 'required|date',
        'aadhaar_card'   => 'required|digits:12|unique:partners,aadhaar_card',
        'pan_card'       => 'required|string|max:10|unique:partners,pan_card',
        'commission'     => 'required|string',
        'status'         => 'required|in:active,inactive',
    ]);

   
    if (auth('employee')->check()) {
        $validated['employee_id'] = auth('employee')->id();
    }

    ChannelPartner::create($validated);

    return redirect()
        ->route('partner.list')
        ->with('success', 'Channel Partner registered successfully!');
}


    /**
     * Show the form for editing the specified channel partner.
     */
    public function edit(int $id): View
    {
        $partner = ChannelPartner::findOrFail($id);
        return view('partner.edit', compact('partner'));
    }

    /**
     * Update the specified channel partner in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $partner = ChannelPartner::findOrFail($id);

        $validated = $request->validate([
            'partner_name'   => 'required|string|max:255',
            'number_contact' => 'required|string|max:20',
            'mail_id'        => 'required|email|unique:partners,mail_id,' . $partner->id,
            'date_of_birth'  => 'required|date',
            'aadhaar_card'   => 'required|digits:12|unique:partners,aadhaar_card,' . $partner->id,
            'pan_card'       => 'required|string|max:10|unique:partners,pan_card,' . $partner->id,
            'commission'     => 'required|string',
            'status'         => 'required|in:active,inactive',
        ]);

        $partner->update($validated);

        return redirect()
            ->route('partner.list')
            ->with('success', 'Channel Partner updated successfully!');
    }

    /**
     * Remove the specified channel partner from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $partner = ChannelPartner::findOrFail($id);
        $partner->delete();

        return redirect()
            ->route('partner.list')
            ->with('success', 'Channel Partner deleted successfully!');
    }

    /**
     * Toggle the active/inactive status of a channel partner.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $partner = ChannelPartner::findOrFail($id);
        $partner->status = $partner->status === 'active' ? 'inactive' : 'active';
        $partner->save();

        return redirect()
            ->route('partner.list')
            ->with('success', 'Channel Partner status updated successfully!');
    }
}
