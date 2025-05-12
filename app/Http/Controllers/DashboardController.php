<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\part;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = part::select('customer')->distinct()->orderBy('customer')->get();
        return view('dashboard_utama', compact('customers'));
    }
}
