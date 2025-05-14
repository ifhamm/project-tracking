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
} 