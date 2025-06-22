<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        try {
            $customer = $request->query('customer');
            
            // Validate customer parameter
            if (!$customer) {
                return response()->json([
                    'error' => 'Customer parameter is required'
                ], 400);
            }
            
            // Get parts data
            if ($customer === 'all') {
                $parts = Part::all();
                $customerName = 'Semua Customer';
            } else {
                $parts = Part::where('customer', $customer)->get();
                $customerName = $customer;
            }
            
            // Check if any parts exist
            if ($parts->isEmpty()) {
                return response()->json([
                    'error' => 'No data found for the specified customer'
                ], 404);
            }
            
            // Generate PDF
            $pdf = Pdf::html(view('export.ExportPart', compact('parts', 'customerName')));
            
            // Set response headers
            return $pdf->download("komponen-{$customerName}.pdf", [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="komponen-' . $customerName . '.pdf"'
            ]);
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('PDF Export Error: ' . $e->getMessage());
            
            // Return error response
            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}