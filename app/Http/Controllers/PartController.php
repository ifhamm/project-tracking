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

    public function create(Request $request)
    {
        $mekanik = akun_mekanik::select('id_credentials', 'name')->where('role', 'mekanik')->get();
        $partsQuery = part::with(['akunMekanik', 'workProgres' => function ($query) {
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
            ]);

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'In Progress') {
                $partsQuery->whereHas('workProgres', function ($q) {
                    $q->where('is_completed', false);
                });
            } elseif ($request->status === 'Completed') {
                $partsQuery->whereDoesntHave('workProgres', function ($q) {
                    $q->where('is_completed', false);
                });
            }
        }

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $partsQuery->where(function ($q) use ($search) {
                $q->where('no_wbs', 'like', "%$search%")
                  ->orWhere('part_name', 'like', "%$search%")
                  ->orWhere('part_number', 'like', "%$search%")
                  ->orWhere('customer', 'like', "%$search%")
                  ->orWhereHas('akunMekanik', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }

        $parts = $partsQuery->orderBy('incoming_date', 'desc')->paginate(10);

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


    public function getByCustomer(Request $request, $customer = null)
    {
        $query = Part::with(['workProgres' => function ($query) {
            $query->orderBy('step_order', 'asc');
        }]);

        if ($customer && $customer !== 'all') {
            $query->where('customer', $customer);
        }

        // Hitung total seluruh part (tanpa pagination)
        $totalAll = (clone $query)->count();

        // Jika ?all=1, kembalikan semua data tanpa pagination (untuk statistik dashboard)
        if ($request->query('all') == 1) {
            $parts = $query->select('no_iwo', 'no_wbs', 'part_name', 'incoming_date', 'is_urgent', 'customer')
                ->orderBy('incoming_date', 'desc')
                ->get();
            $statusCalc = function ($part) {
                $totalSteps = $part->workProgres->count();
                $completedSteps = $part->workProgres->where('is_completed', true)->count();
                if ($totalSteps === 0) {
                    $part->status = 'Belum Diproses';
                } elseif ($completedSteps < $totalSteps) {
                    $part->status = 'In Progress';
                } else {
                    $part->status = 'Completed';
                }
                return $part;
            };
            $parts->transform($statusCalc);
            return response()->json([
                'data' => $parts->values(),
                'total_all' => $totalAll
            ]);
        }

        // If customer is 'all' or null, use pagination
        if (!$customer || $customer === 'all') {
            $parts = $query->select('no_iwo', 'no_wbs', 'part_name', 'incoming_date', 'is_urgent', 'customer')
                ->orderBy('incoming_date', 'desc')
                ->paginate(10);
        } else {
            $parts = $query->select('no_iwo', 'no_wbs', 'part_name', 'incoming_date', 'is_urgent', 'customer')
                ->orderBy('incoming_date', 'desc')
                ->get();
        }

        $statusCalc = function ($part) {
            $totalSteps = $part->workProgres->count();
            $completedSteps = $part->workProgres->where('is_completed', true)->count();
            if ($totalSteps === 0) {
                $part->status = 'Belum Diproses';
            } elseif ($completedSteps < $totalSteps) {
                $part->status = 'In Progress';
            } else {
                $part->status = 'Completed';
            }
            return $part;
        };

        if ($customer && $customer !== 'all') {
            $parts->transform($statusCalc);
        } else {
            $parts->getCollection()->transform($statusCalc);
        }

        if ($parts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $response = $parts->toArray();
            $response['total_all'] = $totalAll;
            return response()->json($response);
        } else {
            return response()->json([
                'data' => $parts->values(),
                'total_all' => $totalAll
            ]);
        }
    }
    public function show($no_iwo)
    {
        $part = part::with('breakdownParts', 'akunMekanik')->findOrFail($no_iwo);
        return view('detail_komponen', compact('part'));
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

    public function setUrgent($no_iwo)
    {
        // Cek apakah part dengan no_iwo ditemukan
        $part = \App\Models\Part::where('no_iwo', $no_iwo)->first();

        if (!$part) {
            return response()->json([
                'success' => false,
                'message' => 'Part tidak ditemukan.'
            ], 404);
        }

        // Set is_urgent menjadi true
        $part->is_urgent = true;
        $part->save();

        return response()->json([
            'success' => true,
            'message' => 'Part berhasil di-set menjadi Urgent!'
        ]);
    }
}
