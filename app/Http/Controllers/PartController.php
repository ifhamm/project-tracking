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
        return view('komponen', compact('mekanik'));
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
        ]);

        part::create($validated);

        return redirect()->route('part.create')->with('success', 'Data part berhasil disimpan.');
    }
}