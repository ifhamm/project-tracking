<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $customer = $request->input('customer');
        $parts = Part::where('customer', $customer)->get();
    
        $pdf = Pdf::html(view('export.ExportPart', compact('parts')));
        return $pdf->download("komponen-{$customer}.pdf");
    }
}
