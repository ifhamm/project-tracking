<?php
namespace App\Http\Controllers;

use App\Models\breakdown_part;
use App\Models\part;
use Illuminate\Http\Request;

class BreakdownPartController extends Controller
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

    public function update(Request $request, $bdp_number)
    {
        $validated = $request->validate([
            'BDP_Name' => 'required|string|max:255',
            'BDP_Number_Eqv' => 'nullable|string|max:255',
            'Quantity' => 'nullable|integer',
            'Unit' => 'nullable|string|max:50',
            'Defect' => 'nullable|string|max:255',
            'OP_Number' => 'nullable|string|max:255',
            'OP_Date' => 'nullable|date',
            'MT_Number' => 'nullable|string|max:255',
            'MT_QTY' => 'nullable|integer',
            'MT_Date' => 'nullable|date',
        ]);

        $breakdownPart = breakdown_part::findOrFail($bdp_number);
        $breakdownPart->update($validated);

        return redirect()->route('breakdown.parts.index')->with('success', 'Breakdown Part Updated Successfully');
    }

    // public function destroy($id)
    // {
    //     $breakdownPart = breakdown_part::findOrFail($id);
    //     $breakdownPart->delete();

    //     return redirect()->route('breakdown.parts.index')->with('success', 'Breakdown Part Deleted Successfully');
    // }
    public function show(Request $request)
    {
        $no_iwo = $request->query('id'); // dari parameter `?id=...`

        $part = part::with('akunMekanik', 'breakdownParts')->where('no_iwo', $no_iwo)->firstOrFail();

        return view('detail_komponen', compact('part'));
    }
}
