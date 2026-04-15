<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    // 🔹 Template List + Create Page
    public function index()
    {
        $documents = Document::latest()->get();
        return view('document.template', compact('documents'));
    }

    // 🔹 Store Template
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'template_html' => 'required'
        ]);

        Document::create($request->all());

        return back()->with('success', 'Template Created');
    }

    // 🔹 Document Create Page
    public function create(Request $request)
    {
        $documents = Document::all();
        $bookings = Booking::with(['customer', 'project'])->get();

        $selectedTemplate = $request->template_id;

        return view('document.create', compact('documents', 'bookings', 'selectedTemplate'));
    }

    // 🔥 Generate Document
  public function generate(Request $request)
{
    $document = Document::findOrFail($request->document_id);
    $booking = Booking::with(['customer', 'project'])->findOrFail($request->booking_id);

    $template = $document->template_html;

    // ✅ SAFE + FORMATTED DATA
    $data = [
        '[[customer_name]]' => $booking->customer->name ?? 'N/A',

        '[[booking_id]]' => $booking->booking_id ?? 'N/A',

        '[[unit_name]]' => $booking->unit_name ?? 'N/A',

        '[[unit_size]]' => $booking->unit_size ?? 'N/A',

        '[[booking_date]]' => $booking->booking_date
            ? date('d M Y', strtotime($booking->booking_date))
            : 'N/A',

        // 🔥 FIXED ₹ ISSUE
'[[total_amount]]' => number_format($booking->total_amount ?? 0),
        '[[project_name]]' => $booking->project->name ?? 'N/A',

        '[[date]]' => now()->format('d M Y'),
    ];

    // 🔥 REPLACE VARIABLES
    foreach ($data as $key => $value) {
        $template = str_replace($key, $value, $template);
    }

    // PDF
    $pdf = Pdf::loadHTML($template);

    return $pdf->stream('document.pdf');
}
}