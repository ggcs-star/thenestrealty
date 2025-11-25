<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\ChannelPartner;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPartners = ChannelPartner::count();
        $totalCustomers = Customer::count();
        $totalLoans = Loan::count();

            return view('dashboard')
        ->with('totalPartners', $totalPartners)
        ->with('totalCustomers', $totalCustomers)
        ->with('totalLoans', $totalLoans)
        ->with('layoutVars', [
            'totalPartners' => $totalPartners,
            'totalCustomers' => $totalCustomers,
            'totalLoans' => $totalLoans
        ]);
    }
}
