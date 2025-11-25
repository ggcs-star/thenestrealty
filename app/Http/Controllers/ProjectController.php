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
        $employees = [];

        if (!auth('employee')->check()) {
            $employees = Employee::all();
        }

        return view('project.create', [
            'user' => $request->user(),
            'employees' => $employees,
        ]);
    }


    public function list(): View
    {
        if (auth('employee')->check()) {
            // Employee login hai → sirf uske records
            $projects = Project::with('employee')
                ->where('assigned_employee', auth('employee')->id())
                ->get();
        } else {
            // Admin login hai → sabhi records
            $projects = Project::with('employee')->get();
        }

        return view('project.list', compact('projects'));
    }


    public function store(Request $request): RedirectResponse
    {
        // Debug: Log the incoming request data
        \Log::info('Project creation request:', $request->all());

        // Agar employee login hai to assigned_employee ko force karo
        if (auth('employee')->check()) {
            $request->merge([
                'assigned_employee' => auth('employee')->id(),
            ]);
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'builder_name' => 'required',
            'builder_number' => 'required',
            'assigned_employee' => 'required|exists:employees,id', // Validate employee ID exists
            'documents.*' => 'file|mimes:xlsx,xls|max:2048',
        ]);

        // Debug: Log validation passed
        \Log::info('Validation passed, processing project creation');

        $unitCount = 0;
        $units = []; // Array to store individual units
        $documentPaths = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');
                $documentPaths[] = $path;

                try {
                    $filePath = $file->getRealPath();
                    \Log::info('Processing file:', ['path' => $filePath, 'original_name' => $file->getClientOriginalName()]);

                    $spreadsheet = IOFactory::load($filePath);
                    $sheet = $spreadsheet->getActiveSheet();

                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    \Log::info('Spreadsheet info:', [
                        'highest_row' => $highestRow,
                        'highest_column' => $highestColumn,
                        'sheet_name' => $sheet->getTitle()
                    ]);

                    if ($highestRow < 1) {
                        \Log::warning("Spreadsheet appears to be empty - no rows found.");
                        continue;
                    }

                    $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];
                    \Log::info('RAW Header Row:', $headerRow);

                    $headers = array_map(function ($h) {
                        return strtolower(trim(strval($h ?? '')));
                    }, $headerRow);

                    \Log::info('Normalized Headers:', $headers);

                    $unitColumnIndex = null;
                    $possibleUnitHeaders = ['unit', 'units', 'unit no', 'unit_no', 'unitno', 'unit number', 'unit_number'];

                    foreach ($possibleUnitHeaders as $possibleHeader) {
                        $index = array_search($possibleHeader, $headers);
                        if ($index !== false) {
                            $unitColumnIndex = $index;
                            \Log::info("Found unit column at index $index with header: $possibleHeader");
                            break;
                        }
                    }

                    if ($unitColumnIndex === null) {
                        \Log::warning("Unit column not found. Available headers:", $headers);
                        continue;
                    }

                    $unitColumnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($unitColumnIndex + 1);

                    if ($highestRow > 1) {
                        $unitColumnData = $sheet->rangeToArray($unitColumnLetter . '2:' . $unitColumnLetter . $highestRow, null, true, false);

                        \Log::info("Unit column data extracted:", ['column' => $unitColumnLetter, 'rows' => count($unitColumnData)]);

                        foreach ($unitColumnData as $rowIndex => $rowData) {
                            $cellValue = $rowData[0] ?? '';
                            $actualRowNumber = $rowIndex + 2;

                            \Log::info("Row $actualRowNumber Unit Value:", [
                                'raw_value' => $cellValue,
                                'type' => gettype($cellValue),
                                'trimmed' => trim(strval($cellValue)),
                                'empty_check' => empty(trim(strval($cellValue)))
                            ]);

                            $stringValue = trim(strval($cellValue));
                            if ($stringValue !== '' && $stringValue !== '0' && !is_null($cellValue)) {
                                $unitCount++;
                                // Add the unit to the units array
                                $units[] = $stringValue;
                            }
                        }
                    }

                    \Log::info("Total units found in this file: $unitCount");
                    \Log::info("Units array:", $units);

                } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                    \Log::error("PhpSpreadsheet Error: " . $e->getMessage());
                    return back()->with('error', 'Excel processing error: ' . $e->getMessage());
                } catch (\Exception $e) {
                    \Log::error("General Excel Parse Error: " . $e->getMessage());
                    return back()->with('error', 'Excel error: ' . $e->getMessage());
                }
            }
        }

        // Debug: Log the data being saved
        $projectData = [
            'name' => $request->name,
            'ex_unit' => $unitCount,
            'units' => $units, // Store the units array
            'address' => $request->address,
            'builder_name' => $request->builder_name,
            'builder_number' => $request->builder_number,
            'assigned_employee' => (int) $request->assigned_employee, // Cast to integer
            'documents' => $documentPaths, // Use array casting from model
        ];

        \Log::info('Creating project with data:', $projectData);

        Project::create($projectData);

        \Log::info('Project created successfully');

        return redirect()->route('projects.list')->with('success', "$unitCount units extracted and project saved.");
    }


    public function edit($id): View
    {
        $project = Project::findOrFail($id);
        $employees = Employee::all();

        return view('project.edit', compact('project', 'employees'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Agar employee login hai to assigned_employee ko force karo
        if (auth('employee')->check()) {
            $request->merge([
                'assigned_employee' => auth('employee')->id(),
            ]);
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

        $unitCount = $project->ex_unit ?? 0; // agar purane units already hai
        $units = $project->units ?? [];
        $documentPaths = $project->documents ?? [];

        // Agar naye documents upload kiye gaye hain
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

        // Project update
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