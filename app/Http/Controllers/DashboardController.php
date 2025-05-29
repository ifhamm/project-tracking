<?php

namespace App\Http\Controllers;

use App\Models\part;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = part::select('customer')->distinct()->orderBy('customer')->get();
        return view('dashboard_utama', compact('customers'));
    }
}
