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
        }, 'akunMekanik'])->get();

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
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto')->store('dokumentasi', 'public');

        dokumentasi_mekanik::create([
            'no_iwo' => $request->no_iwo,
            'no_wbs' => $request->no_wbs,
            'komponen' => $request->komponen,
            'step_name' => $request->step_name,
            'tanggal' => $request->tanggal,
            'foto' => $path,
        ]);

        return back()->with('success', 'Dokumentasi berhasil diunggah.');
    }
}
