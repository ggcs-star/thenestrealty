<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChannelPartnerController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use App\Http\Controllers\PointSettingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create-project', [ProjectController::class, 'index']);
    // Route::get('/create-project', [ProjectController::class, 'index']);
    // Route::get('/project-list', [ProjectController::class, 'list']);
    Route::get('/customer-list', [CustomerController::class, 'list']);
    Route::get('/create-commission', [CommissionController::class, 'index'])->name('commission.create');
    Route::get('/list-commission', [CommissionController::class, 'list'])->name('commission.list');
    Route::get('/project-list', [ProjectController::class, 'list'])->name('projects.list');
    Route::patch('/projects/{id}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggleStatus');
    // API route to get all units and booked units for a project
    Route::get('/api/projects/{id}/units', function ($id) {
        try {
            $project = App\Models\Project::findOrFail($id);
            return response()->json([
                'success' => true,
                'units' => $project->units,
                'booked_units' => $project->booked_units,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    });

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/employees/assign-manager', [EmployeeController::class, 'assignManager'])->name('employees.assignManager');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
        ->name('employees.destroy');

    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('/commissions/fetch', [CommissionController::class, 'fetch'])->name('commissions.fetch');
    Route::post('/commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('/commissions/list', [CommissionController::class, 'list'])->name('commissions.list');
    Route::get('/commissions/{id}', [CommissionController::class, 'show'])->name('commissions.show');
    Route::get('/commissions/{id}/invoice', [CommissionController::class, 'invoice'])
    ->name('commissions.invoice');

Route::get('/commissions/{id}/download', [CommissionController::class, 'download'])
    ->name('commissions.download');
    Route::patch('/commissions/{id}/status', [CommissionController::class, 'updateStatus'])
    ->name('commissions.status.update');
    Route::post('/commissions/{id}/paid', [CommissionController::class, 'markAsPaid'])->name('commissions.markAsPaid');
    Route::delete('/commissions/{id}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
    Route::get('/loans', [LoanController::class, 'index'])->name('loan.index');
    Route::get('/collections/test', [CollectionController::class, 'test'])->name('collections.test');
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/filter/{filter}', [CollectionController::class, 'filter'])->name('collections.filter');
    Route::put('/collections/{id}', [CollectionController::class, 'update'])->name('collections.update');
    Route::get('/collections/{id}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/collections/dashboard', [CollectionController::class, 'dashboard'])->name('collections.dashboard');

    Route::get('/point-settings', [PointSettingController::class, 'index'])->name('point-settings.index');
    Route::post('/point-settings', [PointSettingController::class, 'update'])->name('point-settings.update');



    // Route::get('/partners', [ChannelpartnerController::class, 'index'])->name('partner.list');
    // Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    // Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    // Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');


    // Route::get('/create-collection', [CollectionController::class, 'create'])->name('create-collection');
    // Route::get('/collection-list', [CollectionController::class, 'index'])->name('collection-list');

    // Route::resource('collections', CollectionController::class);
    // Route::get('collections/get-bookings/{customerId}', [CollectionController::class, 'getBookings'])
    //      ->name('collections.get-bookings');
    // Route::get('collections/test-bookings', [CollectionController::class, 'testBookings'])
    //      ->name('collections.test-bookings');

    // Route::prefix('collections')->name('collections.')->group(function () {

    //     // Route to display the form
    //     Route::get('/create', [CollectionController::class, 'create'])->name('create');

    //     // Route to handle form submission
    //     Route::post('/store', [CollectionController::class, 'store'])->name('store');

    //     // Route for the JavaScript to fetch bookings for a selected customer
    //     // This is the crucial new route that makes the dynamic dropdown work.
    //     Route::get('/get-bookings/{customerId}', [CollectionController::class, 'getBookings'])->name('get-bookings');

    // });


});


Route::middleware('employee.guest')->group(function () {
    Route::get('/employee/login', [EmployeeAuthController::class, 'showLoginForm'])
        ->name('employee.login');

    Route::post('/employee/login', [EmployeeAuthController::class, 'login'])
        ->name('employee.login.submit');
});



Route::middleware('multi-auth:web,employee')->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employees.dashboard');
    })->name('employee.dashboard');

    Route::post('/employee/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');
});

Route::middleware(['multi-auth:web,employee'])->group(function () {
    Route::get('/projects/create', [ProjectController::class, 'index'])->name('projects.create');
    Route::get('/project-list', [ProjectController::class, 'list'])->name('projects.list');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::prefix('partners')->name('partner.')->group(function () {
        Route::get('/', [ChannelPartnerController::class, 'list'])->name('list');         // List
        Route::get('/create', [ChannelPartnerController::class, 'create'])->name('create'); // Create Form
        Route::post('/', [ChannelPartnerController::class, 'store'])->name('store');        // Store
        Route::get('/{id}/edit', [ChannelPartnerController::class, 'edit'])->name('edit');  // Edit Form
        Route::put('/{id}', [ChannelPartnerController::class, 'update'])->name('update');   // Update
        Route::delete('/{id}', [ChannelPartnerController::class, 'destroy'])->name('destroy'); // Delete
        Route::post('/{id}/toggle-status', [ChannelPartnerController::class, 'toggleStatus'])->name('toggleStatus'); // Status Toggle
    });


    Route::get('/create-customer', [CustomerController::class, 'index'])->name('customer.create');
    Route::get('/customer-list', [CustomerController::class, 'list'])->name('customer.list');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.create');
    Route::get('/booking-list', [BookingController::class, 'list'])->name('booking.list');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings', [BookingController::class, 'list'])->name('bookings.list');
    Route::get('/loan', [LoanController::class, 'index'])->name('loan.create');
    Route::get('/track-loan', [LoanController::class, 'list'])->name('loan.list');
    Route::post('/loans', [LoanController::class, 'store'])->name('loan.store');


    Route::get('/create-collection', [CollectionController::class, 'create'])->name('create-collection');
    Route::get('/collections/list', [CollectionController::class, 'listCollections'])->name('collections.list');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');


    Route::get('/generate-document', [DocumentController::class, 'index'])->name('document.create');
    Route::get('/template', [DocumentController::class, 'template'])->name('document.template');

});



require __DIR__ . '/auth.php';

// Test route for project creation
Route::get('/test-project-create', function () {
    try {
        $project = App\Models\Project::create([
            'name' => 'Test Project',
            'ex_unit' => 0,
            'units' => [],
            'address' => 'Test Address',
            'builder_name' => 'Test Builder',
            'builder_number' => '1234567890',
            'assigned_employee' => 1,
            'documents' => [],
            'status' => 'Active'
        ]);
        return response()->json(['success' => true, 'project_id' => $project->id]);
    } catch (Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});
