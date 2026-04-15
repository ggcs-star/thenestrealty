<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanStage;

class LoanStageController extends Controller
{
    public function index()
    {
        $stages = LoanStage::latest()->get();
        return view('loan_stages.index', compact('stages'));
    }

    public function create()
    {
        return view('loan_stages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:loan_stages,name'
        ]);

        LoanStage::create([
            'name' => $request->name
        ]);

        // return redirect()->route('loan-stages.index')->with('success', 'Stage Created');
        return redirect()->back()->with('success', 'Stage Created');
    }

    public function edit($id)
    {
        $stage = LoanStage::findOrFail($id);
        return view('loan_stages.edit', compact('stage'));
    }

    public function update(Request $request, $id)
    {
        $stage = LoanStage::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:loan_stages,name,' . $id
        ]);

        $stage->update([
            'name' => $request->name
        ]);

        return redirect()->route('loan-stages.index')->with('success', 'Stage Updated');
    }

    public function destroy($id)
    {
        $stage = LoanStage::findOrFail($id);
        $stage->delete();

        return back()->with('success', 'Stage Deleted');
    }
}