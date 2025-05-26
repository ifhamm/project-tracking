<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;

class KomponenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_wbs' => 'required|string|unique:parts,no_wbs',
            'no_iwo' => 'required|uuid|unique:parts,no_iwo',
            'id_credentials' => 'required|exists:credentials,id_credentials',
        ]);

        $part = Part::create($validated);

        return redirect()->route('proses-mekanik')->with('success', 'Komponen berhasil ditambahkan');
    }

    public function index()
    {
        $parts = Part::with('akunMekanik')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 items per page
        
        return view('komponen', compact('parts'));
    }

    public function edit($no_iwo)
    {
        $part = Part::where('no_iwo', $no_iwo)->firstOrFail();
        $mekanik = \App\Models\akun_mekanik::where('role', 'mekanik')->get();
        return view('komponen-edit', compact('part', 'mekanik'));
    }

    public function update(Request $request, $no_iwo)
    {
        $part = Part::where('no_iwo', $no_iwo)->firstOrFail();
        
        $validated = $request->validate([
            'no_wbs' => 'required|string|unique:parts,no_wbs,' . $part->no_iwo . ',no_iwo',
            'id_credentials' => 'required|exists:credentials,id_credentials',
            'part_name' => 'required|string',
            'part_number' => 'required|string',
            'no_seri' => 'nullable|string',
            'description' => 'nullable|string',
            'customer' => 'required|string',
            'incoming_date' => 'required|date',
            'step_sequence' => 'required|array'
        ]);

        $part->update($validated);

        return redirect()->route('komponen')->with('success', 'Komponen berhasil diperbarui');
    }

    public function destroy($no_iwo)
    {
        $part = Part::where('no_iwo', $no_iwo)->firstOrFail();
        $part->delete();

        return redirect()->route('komponen')->with('success', 'Komponen berhasil dihapus');
    }
} 