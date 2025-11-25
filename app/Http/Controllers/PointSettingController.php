<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Points;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class PointSettingController extends Controller
{
     public function __construct()
    {
        // ensure only logged-in admin (web guard) can access:
        $this->middleware('auth:web');
    }

    // show form
    public function index()
    {
        $setting = Points::current();
        return view('points.index', compact('setting'));
    }

    // update value
    public function update(Request $request)
    {
        $request->validate([
            'rupee_per_point' => 'required|numeric|min:0.01',
        ]);

        $setting = Points::current();
        $setting->update([
            'rupee_per_point' => $request->input('rupee_per_point'),
            'updated_by' => Auth::id(),
        ]);

        // forget cache
        Cache::forget('rupee_per_point');

        return redirect()->route('point-settings.index')
                         ->with('success', 'Point value updated successfully.');
    }
}
