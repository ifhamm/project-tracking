<?php

// app/Http/Controllers/MechanicDocumentationController.php
namespace App\Http\Controllers;

use App\Models\dokumentasi_mekanik;
use Illuminate\Http\Request;
use App\Models\Part;
use Illuminate\Support\Facades\Storage;

class DokumentasiMekanikController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::with(['workProgres', 'akunMekanik', 'dokumentasiMekanik'])
            ->whereHas('workProgres', function ($query) {
                $query->where('is_completed', false);
            });

        if ($request->filled('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        if ($request->filled('no_wbs')) {
            $query->where('no_wbs', 'like', '%' . $request->no_wbs . '%');
        }

        if ($request->filled('teknisi')) {
            $query->whereHas('akunMekanik', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->teknisi . '%');
            });
        }

        $parts = $query->paginate(10)->withQueryString();

        return view('dokumentasi', compact('parts'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'no_iwo' => 'required|string',
            'no_wbs' => 'required|string',
            'komponen' => 'required|string',
            'step_name' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'required|array|min:1',
            'foto.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);


        foreach ($request->file('foto') as $file) {
            $path = $file->store('dokumentasi', 'public');

            dokumentasi_mekanik::create([
                'no_iwo' => $request->no_iwo,
                'no_wbs' => $request->no_wbs,
                'komponen' => $request->komponen,
                'step_name' => $request->step_name,
                'tanggal' => $request->tanggal,
                'foto' => $path,
            ]);
        }

        return back()->with('success', 'Foto dokumentasi berhasil diunggah.');
    }

    public function destroy($id)
    {
        try {
            $doc = dokumentasi_mekanik::findOrFail($id);

            // Hapus file dari storage
            if ($doc->foto && Storage::exists('public/' . $doc->foto)) {
                Storage::delete('public/' . $doc->foto);
            }

            // Hapus dari database
            $doc->delete();

            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto berhasil dihapus'
                ]);
            }

            return back()->with('success', 'Foto berhasil dihapus.');
        } catch (\Exception $e) {
            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus foto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    public function show($no_iwo)
    {
        $part = Part::with(['workProgres' => function ($query) {
            $query->orderBy('step_order', 'asc');
        }, 'akunMekanik', 'dokumentasiMekanik'])->where('no_iwo', $no_iwo)->firstOrFail();

        // Kelompokkan dokumentasi berdasarkan step
        $dokumentasiByStep = $part->dokumentasiMekanik->groupBy('step_name');

        // Debug: Log dokumentasi data
        \Log::info('Dokumentasi data for part ' . $no_iwo, [
            'total_docs' => $part->dokumentasiMekanik->count(),
            'docs_by_step' => $dokumentasiByStep->toArray(),
            'sample_doc' => $part->dokumentasiMekanik->first()
        ]);

        return view('dokumentasi_detail', compact('part', 'dokumentasiByStep'));
    }
}
