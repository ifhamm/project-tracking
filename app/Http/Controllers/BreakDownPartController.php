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
            'No_IWO' => ['required', 'string', 'max:255'],
            'BDP_Name' => 'required|string|max:255',
            'BDP_Number_Eqv' => 'nullable|string|max:255',
            'Quantity' => 'nullable|integer',
            'Unit' => 'nullable|string|max:50',
            'Defect' => 'nullable|string|max:255',
            'OP_Number' => 'nulla   ble|string|max:255',
            'OP_Date' => 'nullable|date',
            'MT_Number' => 'nullable|string|max:255',
            'MT_QTY' => 'nullable|integer',
            'MT_Date' => 'nullable|date',
        ]);

        $data = [
            'no_iwo' => $validated['No_IWO'],
            'bdp_name' => $validated['BDP_Name'],
            'bdp_number_eqv' => $validated['BDP_Number_Eqv'],
            'quantity' => $validated['Quantity'],
            'unit' => $validated['Unit'],
            'defect' => $validated['Defect'],
            'op_number' => $validated['OP_Number'],
            'op_date' => $validated['OP_Date'],
            'mt_number' => $validated['MT_Number'],
            'mt_quantity' => $validated['MT_QTY'],
            'mt_date' => $validated['MT_Date'],
        ];

        breakdown_part::create($data);

        return redirect()->route('detail.komponen', ['id' => $validated['No_IWO']])
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

        $part = part::with('akunMekanik')->where('no_iwo', $no_iwo)->firstOrFail();

        return view('detail_komponen', compact('part'));
    }
}
