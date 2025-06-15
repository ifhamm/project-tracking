<?php

namespace App\Http\Controllers;

use App\Models\part;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = part::select('customer')->distinct()->orderBy('customer')->get();
        return view('dashboard_utama', compact('customers'));
    }

    public function getChartData()
{
    $data = DB::table('work_progres')
        ->join('parts', 'work_progres.no_iwo', '=', 'parts.no_iwo')
        ->selectRaw("DATE_TRUNC('week', work_progres.completed_at) as week, COUNT(DISTINCT work_progres.no_iwo) as total_komponen")
        ->where('work_progres.is_completed', true)
        ->whereNotNull('work_progres.completed_at')
        ->groupByRaw("DATE_TRUNC('week', work_progres.completed_at)")
        ->orderByRaw("DATE_TRUNC('week', work_progres.completed_at)")
        ->get();

    $labels = [];
    $dataPoints = [];

    foreach ($data as $row) {
        $labels[] = date('Y-m-d', strtotime($row->week));
        $dataPoints[] = $row->total_komponen;
    }

    return response()->json([
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Komponen Selesai',
                'data' => $dataPoints,
                'fill' => false,
                'borderColor' => 'rgb(75, 192, 192)',
                'tension' => 0.1,
            ]
        ]
    ]);
}

}
