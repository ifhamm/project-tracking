<?php
namespace App\Http\Controllers;

use App\Models\breakdown_part;
use App\Models\part;
use Illuminate\Http\Request;
use App\Rules\NoXSS;

class BreakDownPartController extends Controller
{
    public function index()
    {
        $breakdownParts = breakdown_part::all();
        return view('detail_komponen', compact('breakdownParts'));
    }

    public function store(Request $request)
    {
        // Get the component to check incoming date
        $part = part::where('no_iwo', $request->no_iwo)->firstOrFail();

        $validated = $request->validate([
            'no_iwo' => ['required', 'string', 'max:255'],
            'bdp_name' => ['required','string','max:255', new NoXSS],
            'bdp_number_eqv' => ['nullable','string','max:255', new NoXSS],
            'quantity' => 'nullable|integer',
            'unit' => ['nullable','string','max:50', new NoXSS],
            'defect' => ['nullable','string','max:255', new NoXSS],
            'op_number' => ['nullable','string','max:255', new NoXSS],
            'op_date' => ['nullable','date', 'after_or_equal:' . $part->incoming_date],
            'mt_number' => ['nullable','string','max:255', new NoXSS],
            'mt_quantity' => 'nullable|integer',
            'mt_date' => ['nullable','date', 'after_or_equal:' . $part->incoming_date],
        ], [
            'op_date.after_or_equal' => 'OP Date tidak boleh lebih awal dari tanggal insert komponen (' . \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') . ')',
            'mt_date.after_or_equal' => 'MT Date tidak boleh lebih awal dari tanggal insert komponen (' . \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') . ')',
        ]);

        $data = [
            'no_iwo' => $validated['no_iwo'],
            'bdp_name' => $validated['bdp_name'],
            'bdp_number_eqv' => $validated['bdp_number_eqv'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'defect' => $validated['defect'],
            'op_number' => $validated['op_number'],
            'op_date' => $validated['op_date'],
            'mt_number' => $validated['mt_number'],
            'mt_quantity' => $validated['mt_quantity'],
            'mt_date' => $validated['mt_date'],
        ];

        breakdown_part::create($data);

        return redirect()->route('detail.komponen', ['id' => $validated['no_iwo']])
            ->with('success', 'Breakdown Part Added Successfully');
    }

    public function update(Request $request, $no_iwo)
    {
        // Get the component to check incoming date
        $part = part::where('no_iwo', $no_iwo)->firstOrFail();

        $validated = $request->validate([
            'bdp_name' => ['required','string','max:255', new NoXSS],
            'bdp_number_eqv' => ['nullable','string','max:255', new NoXSS],
            'quantity' => 'nullable|integer',
            'unit' => ['nullable','string','max:50', new NoXSS],
            'defect' => ['nullable','string','max:255', new NoXSS],
            'op_number' => ['nullable','string','max:255', new NoXSS],
            'op_date' => ['nullable','date', 'after_or_equal:' . $part->incoming_date],
            'mt_number' => ['nullable','string','max:255', new NoXSS],
            'mt_quantity' => 'nullable|integer',
            'mt_date' => ['nullable','date', 'after_or_equal:' . $part->incoming_date],
        ], [
            'op_date.after_or_equal' => 'OP Date tidak boleh lebih awal dari tanggal insert komponen (' . \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') . ')',
            'mt_date.after_or_equal' => 'MT Date tidak boleh lebih awal dari tanggal insert komponen (' . \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') . ')',
        ]);

        $breakdownPart = breakdown_part::where('no_iwo', $no_iwo)->firstOrFail();
        $breakdownPart->update($validated);

        return redirect()->back()->with('success', 'Breakdown Part Updated Successfully');
    }

    public function show(Request $request)
    {
        $no_iwo = $request->query('id'); 

        $part = part::with('akunMekanik', 'breakdownParts')->where('no_iwo', $no_iwo)->firstOrFail();

        return view('detail_komponen', compact('part'));
    }

    public function destroy($bdp_number)
    {
        try {
            $breakdownPart = breakdown_part::where('bdp_number', $bdp_number)->firstOrFail();
            $breakdownPart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Breakdown Part Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Breakdown Part: ' . $e->getMessage()
            ], 500);
        }
    }
}
