<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\WorkProgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Part::select('customer')->distinct()->orderBy('customer')->get();
        return view('dashboard_utama', compact('customers'));
    }

    public function chartData($customer)
    {
        // Chart 1: Status Distribution (Doughnut Chart)
        $statusData = $this->getStatusDistribution($customer);
        
        // Chart 2: Processing Trends (Line Chart)
        $trendData = $this->getProcessingTrends($customer);

        return response()->json([
            'statusChart' => $statusData,
            'trendChart' => $trendData
        ]);
    }

    private function getStatusDistribution($customer)
    {
        $query = Part::with(['workProgres']);

        if ($customer && $customer !== 'all') {
            $query->where('customer', $customer);
        }

        $parts = $query->get();

        $statusCounts = [
            'In Progress' => 0,
            'Completed' => 0,
            'Belum Diproses' => 0
        ];

        foreach ($parts as $part) {
            $totalSteps = $part->workProgres->count();
            $completedSteps = $part->workProgres->where('is_completed', true)->count();
            
            if ($totalSteps === 0) {
                $statusCounts['Belum Diproses']++;
            } elseif ($completedSteps < $totalSteps) {
                $statusCounts['In Progress']++;
            } else {
                $statusCounts['Completed']++;
            }
        }

        return [
            'labels' => array_keys($statusCounts),
            'datasets' => [
                [
                    'data' => array_values($statusCounts),
                    'backgroundColor' => [
                        '#ffc107', // Warning - In Progress
                        '#198754', // Success - Completed
                        '#6c757d'  // Secondary - Belum Diproses
                    ],
                    'borderColor' => [
                        '#ffc107',
                        '#198754',
                        '#6c757d'
                    ],
                    'borderWidth' => 2
                ]
            ]
        ];
    }

    private function getProcessingTrends($customer)
    {
        $query = DB::table('work_progres')
            ->join('parts', 'work_progres.no_iwo', '=', 'parts.no_iwo')
            ->selectRaw("DATE_FORMAT(work_progres.completed_at, '%Y-%m') as month, 
                        COUNT(DISTINCT parts.no_iwo) as total_completed")
            ->where('work_progres.is_completed', true)
            ->whereNotNull('work_progres.completed_at');

        if ($customer && $customer !== 'all') {
            $query->where('parts.customer', $customer);
        }

        $data = $query->groupByRaw("DATE_FORMAT(work_progres.completed_at, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(work_progres.completed_at, '%Y-%m')")
            ->get();

        // Generate last 6 months if no data
        if ($data->isEmpty()) {
            $labels = [];
            $dataPoints = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M Y');
                $dataPoints[] = 0;
            }
        } else {
            $labels = [];
            $dataPoints = [];
            
            foreach ($data as $row) {
                $date = Carbon::createFromFormat('Y-m', $row->month);
                $labels[] = $date->format('M Y');
                $dataPoints[] = $row->total_completed;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Komponen Selesai',
                    'data' => $dataPoints,
                    'fill' => true,
                    'backgroundColor' => 'rgba(25, 135, 84, 0.1)',
                    'borderColor' => 'rgb(25, 135, 84)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointBackgroundColor' => 'rgb(25, 135, 84)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5
                ]
            ]
        ];
    }

    public function getChartData(Request $request)
    {
        $customer = $request->get('customer', 'all');
        return $this->chartData($customer);
    }
}
