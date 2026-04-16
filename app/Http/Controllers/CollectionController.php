<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use App\Models\Employee;

class CollectionController extends Controller
{
  public function create(): View
{
    if (auth('employee')->check()) {

        $user = auth('employee')->user();

        if ($user->isManager()) {

            $teamIds = Employee::where('manager_id', $user->id)
                ->pluck('id')
                ->push($user->id)
                ->toArray();

            $customers = Customer::whereIn('employee_id', $teamIds)
                ->select('id', 'name')
                ->get();

            $BookingId = Booking::whereIn('employee_id', $teamIds)
                ->select('id', 'booking_id')
                ->get();
        }

        else {

            $employeeId = $user->id;

            $customers = Customer::where('employee_id', $employeeId)
                ->select('id', 'name')
                ->get();

            $BookingId = Booking::where('employee_id', $employeeId)
                ->select('id', 'booking_id')
                ->get();
        }
    }

    else {

        $customers = Customer::select('id', 'name')->get();
        $BookingId = Booking::select('id', 'booking_id')->get();
    }

    return view('collections.create', compact('customers', 'BookingId'));
}


    public function index(Request $request)
    {
        try {
            $query = Collection::query()->with(['customer', 'booking']); // eager load relationships
            $filter = strtolower($request->get('filter'));
            $specificDate = $request->get('date');
            $from = $request->get('from');
            $to = $request->get('to');
            $today = Carbon::today();

            switch ($filter) {
                case 'today':
                    $query->whereDate('date', $today);
                    break;
                case 'upcoming':
                    $query->whereDate('date', '>', $today);
                    break;
                case 'backlog':
                    $query->whereDate('date', '<', $today);
                    break;
                case 'complete':
                    // If you have a status field, use it here
                    // Otherwise, keep this commented out
                    // $query->where('status', 'completed');
                    break;
            }

            // Filter by specific date if provided
            if ($specificDate) {
                $query->whereDate('date', $specificDate);
            }

            // Filter by date range if provided
            if ($from && $to) {
                $query->whereBetween('date', [$from, $to]);
            } elseif ($from) {
                $query->whereDate('date', '>=', $from);
            } elseif ($to) {
                $query->whereDate('date', '<=', $to);
            }

            $collections = $query->orderBy('date', 'desc')->get();

            return view('collections.list', compact('collections', 'filter'));
        } catch (\Exception $e) {
            Log::error("Failed to fetch collections", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load collections: ' . $e->getMessage());
        }
    }



//     public function listCollections(): View
// {
//     try {
//         $query = Collection::with(['customer', 'booking']);

//         // ✅ Check agar employee login hai
//         if (auth('employee')->check()) {
//             $employeeId = auth('employee')->id();
//             $query->where('employee_id', $employeeId);
//         }

//         $filter = strtolower(request('filter'));
//         $from = request('from');
//         $to = request('to');
//         $specificDate = request('date');
//         $today = now()->toDateString();

//         switch ($filter) {
//             case 'today':
//                 $query->whereDate('date', $today);
//                 break;
//             case 'backlog':
//                 $query->whereDate('date', '<', $today);
//                 break;
//             case 'upcoming':
//                 $query->whereDate('date', '>', $today);
//                 break;
//             case 'complete':
//                 // Example agar status use karte ho
//                 // $query->where('status', 'completed');
//                 break;
//         }

//         if ($specificDate) {
//             $query->whereDate('date', $specificDate);
//         }

//         if ($from && $to) {
//             $query->whereBetween('date', [$from, $to]);
//         } elseif ($from) {
//             $query->whereDate('date', '>=', $from);
//         } elseif ($to) {
//             $query->whereDate('date', '<=', $to);
//         }

//         $collections = $query->orderBy('date', 'desc')->get();

//         return view('collections.list', compact('collections'));
//     } catch (\Exception $e) {
//         Log::error("Failed to fetch collections", [
//             'error' => $e->getMessage()
//         ]);

//         return view('collections.list', ['collections' => collect()])
//             ->withErrors(['error' => 'Failed to load collections: ' . $e->getMessage()]);
//     }
// }


public function listCollections(): View
{
    try {
        $query = Collection::with(['customer', 'booking']);

        // ===============================
        // 🔐 ROLE BASED FILTER
        // ===============================
        if (auth('employee')->check()) {

            $user = auth('employee')->user();

            // ✅ Manager → self + team
            if ($user->isManager()) {

                $teamIds = Employee::where('manager_id', $user->id)
                    ->pluck('id')
                    ->push($user->id)
                    ->toArray();

                $query->whereIn('employee_id', $teamIds);
            }

            // ✅ Employee → only self
            else {
                $query->where('employee_id', $user->id);
            }
        }

        // ===============================
        // 📅 DATE FILTER
        // ===============================
        $from = request('from');
        $to = request('to');

        if ($from && $to) {
            $query->whereBetween('date', [$from, $to]);
        } elseif ($from) {
            $query->whereDate('date', '>=', $from);
        } elseif ($to) {
            $query->whereDate('date', '<=', $to);
        }

        // ===============================
        // 🎯 STATUS
        // ===============================
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // ===============================
        // 🔍 SEARCH
        // ===============================
        if (request('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                })->orWhereHas('booking', function ($q3) use ($search) {
                    $q3->where('booking_id', 'like', "%$search%");
                });
            });
        }

        // ===============================
        // ✅ PAGINATION
        // ===============================
        $collections = $query->orderBy('date', 'desc')->paginate(10);

        return view('collections.list', compact('collections'));

    } catch (\Exception $e) {

        Log::error("Failed to fetch collections", [
            'error' => $e->getMessage()
        ]);

        return view('collections.list', ['collections' => collect()])
            ->withErrors(['error' => 'Failed to load collections']);
    }
}
    public function test()
    {
        try {
            DB::connection()->getPdo();
            $tableExists = Schema::hasTable('collections');
            $columns = $tableExists ? Schema::getColumnListing('collections') : [];

            return response()->json([
                'database_connected' => true,
                'collections_table_exists' => $tableExists,
                'columns' => $columns
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'database_connected' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        // ✅ 1. Check database connection
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Log::error("Database connection failed", ['error' => $e->getMessage()]);
            return back()->with('error', 'Database connection failed. Please check your configuration.')
                ->withInput();
        }

        // ✅ 2. Ensure table exists (optional in production)
        if (!Schema::hasTable('collections')) {
            Log::error("Collections table does not exist");
            return back()->with('error', 'Collections table does not exist. Please run migrations.')
                ->withInput();
        }

        // ✅ 3. Validate required fields
        $request->validate([
            'booking_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'partner_id' => 'required|integer',
            'project_id' => 'required|integer',
            // 'status'      => 'nullebl|in:Completed,Pending',
        ]);

        $modes = ['loan', 'transfer', 'other'];
        $createdCount = 0;
        $errors = [];

        // ✅ Employee ID from auth (if logged in as employee)
        $employeeId = auth('employee')->check() ? auth('employee')->id() : null;

        // ✅ 4. Loop through modes and insert data
        foreach ($modes as $mode) {
            $dates = $request->input("{$mode}_dates", []);
            $amounts = $request->input("{$mode}_amounts", []);

            Log::info("Processing mode: {$mode}", ['dates' => $dates, 'amounts' => $amounts]);

            if (empty($dates) || empty($amounts)) {
                continue; // skip agar dono me data nahi hai
            }

            if (count($dates) !== count($amounts)) {
                $errors[] = ucfirst($mode) . " data mismatch between dates and amounts.";
                continue;
            }

            foreach ($dates as $index => $date) {
                $amount = $amounts[$index] ?? null;

                if (!empty($date) && !empty($amount)) {
                    try {
                        Collection::create([
                            'booking_id' => $request->booking_id,
                            'customer_id' => $request->customer_id,
                            'partner_id' => $request->partner_id,
                            'project_id' => $request->project_id,
                            'employee_id' => $employeeId,
                            'date' => $date,
                            'amount' => $amount,
                            'mode' => ucfirst($mode),
                            'status' => $request->status ?? 'Pending', // ✅ default
                        ]);
                        $createdCount++;
                    } catch (\Exception $e) {
                        $errors[] = "Failed to create {$mode} record for {$date}: " . $e->getMessage();
                        Log::error("Failed to create collection", [
                            'mode' => $mode,
                            'date' => $date,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
        }


        // ✅ 5. Return response
        if ($createdCount > 0) {
            $message = "Successfully saved {$createdCount} payment commitment(s)!";
            if (!empty($errors)) {
                $message .= " Some issues occurred: " . implode(' | ', $errors);
            }
            return back()->with('success', $message);
        }

        return back()->with('error', 'No valid payment commitments found or all failed.')
            ->withInput();
    }


    public function edit($id): View
    {
        $collection = Collection::findOrFail($id);
        $customers = Customer::select('id', 'name')->get();
        $BookingId = Booking::select('id', 'booking_id')->get();

        return view('collections.edit', compact('collection', 'customers', 'BookingId'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'partner_id' => 'required|integer',
            'project_id' => 'required|integer',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'mode' => 'required|string|in:Loan,Transfer,Other',
            'status' => 'required|in:Completed,Pending',
        ]);

        try {
            $collection = Collection::findOrFail($id);

            $collection->update([
                'booking_id' => $request->booking_id,
                'customer_id' => $request->customer_id,
                'partner_id' => $request->partner_id,
                'project_id' => $request->project_id,
                'date' => $request->date,
                'amount' => $request->amount,
                'mode' => $request->mode,
                'status' => $request->status,
            ]);

            return redirect()->route('collections.index')->with('success', 'Collection updated successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to update collection", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }




    public function dashboard(): View
    {
        try {
            $today = Carbon::today();
            $collections = Collection::with(['customer', 'booking'])
                ->orderBy('date', 'desc')
                ->get();

            $todayFollowUps = $collections->filter(fn($c) => Carbon::parse($c->date)->isToday());
            $historyFollowUps = $collections->filter(fn($c) => Carbon::parse($c->date)->isBefore($today));
            $recentFollowUps = $collections->take(3);

            return view('collections.dashboard', compact(
                'todayFollowUps',
                'historyFollowUps',
                'recentFollowUps'
            ));
        } catch (\Exception $e) {
            Log::error("Failed to fetch dashboard data", ['error' => $e->getMessage()]);
            return view('collections.dashboard')->withErrors([
                'error' => 'Failed to load dashboard data: ' . $e->getMessage()
            ]);
        }
    }

    // ✅ NEW FILTER METHOD
    public function filter($filter)
    {
        try {
            $today = Carbon::today();
            $query = Collection::with(['customer', 'booking']);
            $specificDate = request('date');
            $from = request('from');
            $to = request('to');

            switch (strtolower($filter)) {
                case 'today':
                    $query->whereDate('date', $today);
                    break;

                case 'backlog':
                    $query->whereDate('date', '<', $today);
                    break;

                case 'upcoming':
                    $query->whereDate('date', '>', $today);
                    break;

                case 'complete':
                    // If you have a status field, use it here
                    // Otherwise, you can use a different logic or remove this case
                    // $query->where('status', 'completed');
                    break;

                default:
                    // fallback to all
                    $query->orderBy('date', 'desc');
            }

            // Filter by specific date if provided
            if ($specificDate) {
                $query->whereDate('date', $specificDate);
            }

            // Filter by date range if provided
            if ($from && $to) {
                $query->whereBetween('date', [$from, $to]);
            } elseif ($from) {
                $query->whereDate('date', '>=', $from);
            } elseif ($to) {
                $query->whereDate('date', '<=', $to);
            }

            $collections = $query->orderBy('date', 'asc')->get();

            return view('collections.list', compact('collections', 'filter'));
        } catch (\Exception $e) {
            Log::error("Filter error", ['filter' => $filter, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to apply filter.');
        }
    }

    public function toggleStatus($id): RedirectResponse
    {
        $collections = Collection::findOrFail($id);
        $collections->status = $collections->status === 'completed' ? 'pending' : 'completed';
        $collections->save();

        return redirect()->route('collections.index')
            ->with('success', 'Collections status updated.');
    }
}
