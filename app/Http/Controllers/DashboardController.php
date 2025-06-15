<?php

namespace App\Http\Controllers;

use App\Models\part;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = part::select('customer')->distinct()->orderBy('customer')->get();

        $parts = part::orderBy('is_urgent', 'desc')->get();

        return view('dashboard_utama', compact('customers', 'parts'));
    }

    public function setPriority($no_iwo)
    {
        // Cari berdasarkan no_iwo
        $part = Part::where('no_iwo', $no_iwo)->first();

        if (!$part) {
            return response()->json([
                'message' => 'Part not found',
                'status' => false,
            ], 404);
        }

        // Toggle nilai is_urgent
        $part->is_urgent = !$part->is_urgent;
        $part->save();

        return response()->json([
            'message' => 'Priority status updated successfully',
            'is_urgent' => $part->is_urgent,
            'status' => true,
        ]);
    }
}
