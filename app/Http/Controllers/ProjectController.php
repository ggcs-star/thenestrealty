<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $employees = collect();

        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {
                $employees = Employee::where('manager_id', $user->id)->get();
            } else {
                $employees = collect();
            }
        } else {
            $employees = Employee::all();
        }

        return view('project.create', [
            'user' => $request->user(),
            'employees' => $employees,
        ]);
    }
    public function list(Request $request): View
    {
        $query = Project::with('employee');

        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {

                $query->where(function ($q) use ($user) {

                    $q->where('assigned_employee', $user->id)

                        ->orWhereIn('assigned_employee', function ($sub) use ($user) {
                            $sub->select('id')
                                ->from('employees')
                                ->where('manager_id', $user->id);
                        });
                });
            } else {
                $query->where('assigned_employee', $user->id);
            }
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('builder_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('builder_number', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->employee_id && !auth('employee')->check()) {
            $query->where('assigned_employee', $request->employee_id);
        }

        $projects = $query->latest()->paginate(5)->withQueryString();

        $employees = Employee::all();

        return view('project.list', compact('projects', 'employees'));
    }


    // public function list(): View
    // {
    //     if (auth('employee')->check()) {
    //         // Employee login hai → sirf uske records
    //         $projects = Project::with('employee')
    //             ->where('assigned_employee', auth('employee')->id())
    //             ->get();
    //     } else {
    //         // Admin login hai → sabhi records
    //         $projects = Project::with('employee')->get();
    //     }

    //     return view('project.list', compact('projects'));
    // }


    public function store(Request $request): RedirectResponse
    {


        $user = auth('employee')->user();

        if (auth('employee')->check()) {

            if (!$user->isManager()) {
                $request->merge([
                    'assigned_employee' => $user->id,
                ]);
            }

        }
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'builder_name' => 'required',
            'builder_number' => 'required',
            'assigned_employee' => 'required|exists:employees,id',
            'documents.*' => 'file|mimes:xlsx,xls|max:2048',
        ]);

        $unitCount = 0;
        $units = [];
        $unitSizes = [];
        $documentPaths = [];

        if ($request->hasFile('documents')) {

            foreach ($request->file('documents') as $file) {

                $path = $file->store('documents', 'public');
                $documentPaths[] = $path;

                try {

                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();

                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    $headers = array_map(
                        fn($h) => strtolower(trim($h)),
                        $sheet->rangeToArray('A1:' . $highestColumn . '1')[0]
                    );

                    $unitColumnIndex = null;
                    foreach (['unit', 'units', 'unit no', 'unit number'] as $h) {
                        $i = array_search($h, $headers);
                        if ($i !== false) {
                            $unitColumnIndex = $i;
                            break;
                        }
                    }

                    $sizeColumnIndex = null;
                    foreach (['size', 'unit size', 'area'] as $h) {
                        $i = array_search($h, $headers);
                        if ($i !== false) {
                            $sizeColumnIndex = $i;
                            break;
                        }
                    }

                    if ($unitColumnIndex === null)
                        continue;

                    $unitCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($unitColumnIndex + 1);
                    $sizeCol = $sizeColumnIndex !== null
                        ? \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($sizeColumnIndex + 1)
                        : null;

                    for ($row = 2; $row <= $highestRow; $row++) {

                        $unitValue = trim((string) $sheet->getCell($unitCol . $row)->getValue());
                        if ($unitValue === '')
                            continue;

                        $unitCount++;
                        $units[] = $unitValue;

                        if ($sizeCol) {
                            $unitSizes[$unitValue] = trim((string) $sheet->getCell($sizeCol . $row)->getValue());
                        }
                    }

                } catch (\Exception $e) {
                    \Log::error("Excel Error: " . $e->getMessage());
                    return back()->with('error', $e->getMessage());
                }
            }
        }

        $projectData = [
            'name' => $request->name,
            'ex_unit' => $unitCount,
            'units' => $units,
            'unit_sizes' => $unitSizes,
            'address' => $request->address,
            'builder_name' => $request->builder_name,
            'builder_number' => $request->builder_number,
            'assigned_employee' => (int) $request->assigned_employee,
            'documents' => $documentPaths,
        ];

        \App\Models\Project::create($projectData);

        \Log::info('Project created successfully', [
            'units' => $unitCount
        ]);

        return redirect()->route('projects.list')
            ->with('success', "$unitCount units imported successfully");

    }




    public function edit($id): View
    {
        $project = Project::findOrFail($id);
        $employees = collect();

        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            if ($user->isManager()) {
                $employees = Employee::where('manager_id', $user->id)->get();
            } else {
                $employees = collect();
            }
        } else {
            $employees = Employee::all();
        }

        return view('project.edit', compact('project', 'employees'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = auth('employee')->user();

        if (auth('employee')->check()) {

            if (!$user->isManager()) {
                $request->merge([
                    'assigned_employee' => $user->id,
                ]);
            } else {
                $validEmployeeIds = Employee::where('manager_id', $user->id)->pluck('id')->toArray();

                if (!in_array($request->assigned_employee, $validEmployeeIds)) {
                    return back()->with('error', 'Invalid employee selected.');
                }
            }
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'builder_name' => 'required',
            'builder_number' => 'required',
            'assigned_employee' => 'required|exists:employees,id',
            'documents.*' => 'file|mimes:xlsx,xls|max:2048',
        ]);

        $project = Project::findOrFail($id);

        $unitCount = $project->ex_unit ?? 0;
        $units = $project->units ?? [];
        $documentPaths = $project->documents ?? [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');
                $documentPaths[] = $path;

                try {
                    $filePath = $file->getRealPath();
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                    $sheet = $spreadsheet->getActiveSheet();

                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];
                    $headers = array_map(function ($h) {
                        return strtolower(trim(strval($h ?? '')));
                    }, $headerRow);

                    $unitColumnIndex = null;
                    $possibleUnitHeaders = ['unit', 'units', 'unit no', 'unit_no', 'unitno', 'unit number', 'unit_number'];

                    foreach ($possibleUnitHeaders as $possibleHeader) {
                        $index = array_search($possibleHeader, $headers);
                        if ($index !== false) {
                            $unitColumnIndex = $index;
                            break;
                        }
                    }

                    if ($unitColumnIndex !== null && $highestRow > 1) {
                        $unitColumnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($unitColumnIndex + 1);
                        $unitColumnData = $sheet->rangeToArray($unitColumnLetter . '2:' . $unitColumnLetter . $highestRow, null, true, false);

                        foreach ($unitColumnData as $rowData) {
                            $stringValue = trim(strval($rowData[0] ?? ''));
                            if ($stringValue !== '' && $stringValue !== '0') {
                                $unitCount++;
                                $units[] = $stringValue;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Excel parse error in update: " . $e->getMessage());
                    return back()->with('error', 'Excel error: ' . $e->getMessage());
                }
            }
        }

        $project->update([
            'name' => $request->name,
            'address' => $request->address,
            'builder_name' => $request->builder_name,
            'builder_number' => $request->builder_number,
            'assigned_employee' => (int) $request->assigned_employee,
            'ex_unit' => $unitCount,
            'units' => $units,
            'documents' => $documentPaths,
        ]);

        return redirect()->route('projects.list')->with('success', 'Project updated successfully.');
    }


    public function destroy($id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.list')->with('success', 'Project deleted successfully.');
    }

    public function toggleStatus($id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $project->status = $project->status === 'Active' ? 'Inactive' : 'Active';
        $project->save();

        return redirect()->route('projects.list')->with('success', 'Project status updated successfully.');
    }
}