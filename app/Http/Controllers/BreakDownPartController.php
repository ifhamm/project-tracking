<?php
namespace App\Http\Controllers;

use App\Models\breakdown_part;
use App\Models\part;
use Illuminate\Http\Request;

class BreakDownPartController extends Controller
{
    public function index()
    {
        $breakdownParts = breakdown_part::all();
        return view('detail_komponen', compact('breakdownParts'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'no_iwo' => ['required', 'string', 'max:255'],
            'bdp_name' => 'required|string|max:255',
            'bdp_number_eqv' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'defect' => 'nullable|string|max:255',
            'op_number' => 'nullable|string|max:255',
            'op_date' => 'nullable|date',
            'mt_number' => 'nullable|string|max:255',
            'mt_quantity' => 'nullable|integer',
            'mt_date' => 'nullable|date',
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
        $validated = $request->validate([
            'bdp_name' => 'required|string|max:255',
            'bdp_number_eqv' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'defect' => 'nullable|string|max:255',
            'op_number' => 'nullable|string|max:255',
            'op_date' => 'nullable|date',
            'mt_number' => 'nullable|string|max:255',
            'mt_quantity' => 'nullable|integer',
            'mt_date' => 'nullable|date',
        ]);

        $breakdownPart = breakdown_part::where('no_iwo', $no_iwo)->firstOrFail();
        $breakdownPart->update($validated);

        return redirect()->back()->with('success', 'Breakdown Part Updated Successfully');
    }

    public function destroy($no_iwo)
    {
        $breakdownPart = breakdown_part::where('no_iwo', $no_iwo)->firstOrFail();
        $breakdownPart->delete();

        return redirect()->back()->with('success', 'Breakdown Part Deleted Successfully');
    }

    public function show(Request $request)
    {
        $no_iwo = $request->query('id'); 

        $part = part::with('akunMekanik', 'breakdownParts')->where('no_iwo', $no_iwo)->firstOrFail();

        return view('detail_komponen', compact('part'));
    }
}
