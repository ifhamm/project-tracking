<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getData($customer)
    {
        // Data dummy, bisa nanti diganti dengan query ke DB
        $data = [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'datasets' => [
                [
                    'label' => "Progres $customer",
                    'data' => [10, 30, 60, 90],
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ]
            ]
        ];

        return response()->json($data);
    }
}

