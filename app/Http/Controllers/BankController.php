<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::latest()->paginate(10);
        return view('banks.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|unique:banks,name|max:255']);

        $bank = Bank::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Bank added successfully.', 'bank' => $bank]);
        }

        return back()->with('success', 'Bank added successfully.');
    }

    public function destroy(Bank $bank)
    {
        if ($bank->loans()->exists()) {
            return back()->with('error', 'Cannot delete a bank that is associated with existing loans.');
        }
        $bank->delete();
        return back()->with('success', 'Bank deleted successfully.');
    }
}