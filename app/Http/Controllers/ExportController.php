<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $customer = $request->query('customer'); // Gunakan query() untuk GET parameter
        
        // Jika customer adalah 'all', ambil semua data
        if ($customer === 'all') {
            $parts = Part::all();
            $customerName = 'Semua Customer';
        } 
        // Jika customer ada nilainya tapi bukan 'all'
        else if ($customer) {
            $parts = Part::where('customer', $customer)->get();
            $customerName = $customer;
        } 
        // Jika tidak ada customer yang dipilih
        else {
            $parts = Part::all();
            $customerName = 'Semua Customer';
        }
    
        return Pdf::html(view('export.ExportPart', compact('parts', 'customerName')))
            ->download("komponen-{$customerName}.pdf");
    }
}