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

    public function export($customers)
    {
        $parts = part::where('customer', $customers)
            ->with('breakdown_part', 'akun_mekanik', 'workProgres')
            ->orderBy('incoming_date')
            ->get();

        if ($parts->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data Part yang ditemukan untuk customer: ' . $customers);
        }

        $safeCustomerName = Str::slug($customers, '_');
        $fileName = 'parts_export_customer_' . $safeCustomerName . '_' . date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('exports.parts_by_customer_pdf', compact('parts', 'customer'))
            ->setPaper('a4')
            ->setOptions([
                'footer-center' => 'PT Dirgantara Indonesia',
                'footer-font-size' => 10,
            ])
            ->setWatermark(public_path('https://www.indonesian-aerospace.com/assets/img/logo/logo.png'))
            ->setWatermarkPosition('center');

        return $pdf->download($fileName);
    }
}
