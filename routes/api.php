<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/projects/{project}/units', function (Project $project) {

    $units = $project->units ?? [];
    $unitSizes = $project->unit_sizes ?? [];
    $bookedUnits = $project->booked_units ?? [];

    $unitSizeMap = [];

    foreach ($units as $unit) {
        $unitSizeMap[$unit] = $unitSizes[$unit] ?? null;
    }

    return response()->json([
        'success' => true,
        'units' => $units,
        'unit_sizes' => $unitSizes,
        'unit_size_map' => $unitSizeMap,
        'booked_units' => $bookedUnits,
        'ex_unit' => $project->ex_unit
    ]);

})->name('api.projects.units');