<?php

namespace App\Http\Controllers;

use App\Models\part;    
use Illuminate\Http\Request;
use App\Models\akun_mekanik;
use Illuminate\Support\Str;

class PartController extends Controller
{
    public function create()
    {
        $mekanik = akun_mekanik::all();
        $parts = part::with('akunMekanik')->get();
        return view('komponen', compact('mekanik', 'parts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_wbs' => 'required|string|max:255',
            'incoming_date' => 'required|date',
            'part_name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'no_seri' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'customer' => 'required|string|max:255',
            'id_mekanik' => 'required|uuid',
        ]);

        $part = [
            'no_iwo' => Str::uuid(),
            'no_wbs' => $validated['no_wbs'],
            'incoming_date' => $validated['incoming_date'],
            'part_name' => $validated['part_name'],
            'part_number' => $validated['part_number'],
            'no_seri' => $validated['no_seri'],
            'description' => $validated['description'],
            'customer' => $validated['customer'],
            'id_mekanik' => $validated['id_mekanik'],
        ];

        part::create($part);

        return redirect()->route('part.create')->with('success', 'Data part berhasil disimpan.');
    }
}