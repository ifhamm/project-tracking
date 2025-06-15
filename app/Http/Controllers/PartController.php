<?php

namespace App\Http\Controllers;

use App\Models\part;
use Illuminate\Http\Request;
use App\Models\akun_mekanik;
use Illuminate\Support\Str;
use App\Helpers\DateHelper;

class PartController extends Controller
{

    protected DateHelper $dateHelper;

    public function __construct(DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
    }

    public function create()
    {
        $mekanik = akun_mekanik::select('id_credentials', 'name')->where('role', 'mekanik')->get();
        $parts = part::with(['akunMekanik', 'workProgres' => function ($query) {
            $query->orderBy('step_order', 'asc');
        }])
            ->select([
                'no_iwo',
                'no_wbs',
                'part_name',
                'part_number',
                'incoming_date',
                'customer',
                'id_credentials'
            ])
            ->orderBy('incoming_date', 'desc')
            ->paginate(10);

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
            'id_credentials' => 'required|uuid',
            'step_sequence' => 'required|array',
            'step_sequence.*' => 'required|integer|between:1,8',
        ]);

        // Hitung deadline berdasarkan incoming_date
        $deadline = $this->dateHelper->calculateWorkingDeadline($validated['incoming_date']);

        $part = [
            'no_iwo' => Str::uuid(),
            'no_wbs' => $validated['no_wbs'],
            'incoming_date' => $validated['incoming_date'],
            'priority_deadline_date' => $deadline,
            'part_name' => $validated['part_name'],
            'part_number' => $validated['part_number'],
            'no_seri' => $validated['no_seri'],
            'description' => $validated['description'],
            'customer' => $validated['customer'],
            'id_credentials' => $validated['id_credentials'],
        ];

        $newPart = \App\Models\part::create($part);

        // Buat work progres untuk setiap step
        $stepNames = [
            1 => 'Incoming',
            2 => 'Pre Test',
            3 => 'Disassembly',
            4 => 'Check + Stripping',
            5 => 'Cleaning',
            6 => 'Assembly + Repair',
            7 => 'Post Test',
            8 => 'Final Inspection'
        ];

        foreach ($validated['step_sequence'] as $order => $stepNumber) {
            \App\Models\work_progres::create([
                'id_progres' => Str::uuid(),
                'no_iwo' => $newPart->no_iwo,
                'step_order' => $order + 1,
                'step_name' => $stepNames[$stepNumber],
                'is_completed' => false,
            ]);
        }

        return redirect()->route('komponen')->with('success', 'Data part berhasil disimpan dengan priority deadline.');
    }


    public function getByCustomer($customer = null)
    {
        $query = Part::query();

        if ($customer && $customer !== 'all') {
            $query->where('customer', $customer);
        }

        $parts = $query->select('no_wbs', 'part_name', 'incoming_date', 'is_urgent')
            ->get();

        return response()->json($parts);
    }
    public function show($no_iwo)
    {
        $part = part::with('breakdownParts', 'akunMekanik')->findOrFail($no_iwo);
        return view('detail_komponen', compact('part'));
    }

    public function edit($no_iwo)
    {
        $part = part::where('no_iwo', $no_iwo)->firstOrFail();
        $mekanik = \App\Models\akun_mekanik::where('role', 'mekanik')->get();
        return view('komponen-edit', compact('part', 'mekanik'));
    }

    public function update(Request $request, $no_iwo)
    {
        $part = part::where('no_iwo', $no_iwo)->firstOrFail();

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
        $part = part::where('no_iwo', $no_iwo)->firstOrFail();
        $part->delete();

        return redirect()->route('komponen')->with('success', 'Komponen berhasil dihapus');
    }
}
