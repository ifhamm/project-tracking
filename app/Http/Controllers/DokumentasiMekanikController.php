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
        $parts = Part::with(['workProgres' => function ($query) {
            $query->where('is_completed', false);
        }, 'akunMekanik'])->paginate(5);


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


    public function filter(Request $request)
    {
        $query = Part::query();

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

        $parts = $query->with([
            'workProgres' => function ($query) {
                $query->where('is_completed', false);
            },
            'akunMekanik',
            'dokumentasiMekanik'
        ])->paginate(5);


        return view('dokumentasi', compact('parts'));
    }

    public function destroy($id)
{
    $doc = dokumentasi_mekanik::findOrFail($id);

    // Hapus file dari storage
    if ($doc->foto && Storage::exists('public/' . $doc->foto)) {
        Storage::delete('public/' . $doc->foto);
    }

    // Hapus dari database
    $doc->delete();

    return back()->with('success', 'Foto berhasil dihapus.');
}

}
