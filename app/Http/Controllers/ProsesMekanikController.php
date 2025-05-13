<?php

namespace App\Http\Controllers;

use App\Models\part;
use App\Models\work_progres;
use Illuminate\Http\Request;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

class ProsesMekanikController extends Controller
{
    public function index(Request $request)
    {
        $query = part::with(['akunMekanik', 'workProgres' => function ($query) {
            $query->orderBy('step_order', 'asc');
        }]);

        // Only show parts that have at least one incomplete step
        $query->whereHas('workProgres', function ($q) {
            $q->where('is_completed', false);
        });

        // Search by component number
        if ($request->filled('no_wbs')) {
            $query->where('no_wbs', 'like', '%' . $request->no_wbs . '%');
        }

        // Search by technician
        if ($request->filled('teknisi')) {
            $query->whereHas('akunMekanik', function ($q) use ($request) {
                $q->where('nama_mekanik', 'like', '%' . $request->teknisi . '%');
            });
        }

        // Search by current step
        if ($request->filled('step')) {
            $query->whereHas('workProgres', function ($q) use ($request) {
                $q->where('step_name', 'like', '%' . $request->step . '%')
                    ->where('is_completed', false);
            });
        }

        $parts = $query->get()->map(function ($part) {
            $currentStep = $part->workProgres->where('is_completed', false)->first();
            $nextStep = null;

            if ($currentStep) {
                $nextStep = $part->workProgres
                    ->where('step_order', '>', $currentStep->step_order)
                    ->first();
            }

            $part->next_step = $nextStep ? $nextStep->step_name : null;

            // === Urgency Logic ===
            $part->urgency_icon = null;
            $part->days_left = null;

            if ($part->is_urgent) {
                $part->urgency_icon = 'red'; 
                $part->days_left = 0; 
            } elseif ($part->incoming_date) {
                $daysLeft = \App\Helpers\DateHelper::daysLeftUntilDeadline($part->incoming_date);
                $part->days_left = $daysLeft;
                if ($daysLeft <= 5) {
                    $part->urgency_icon = 'yellow'; // tanda seru kuning
                }
            }

            return $part;
        })->sortBy([
            ['is_urgent', 'desc'], 
            ['days_left', 'asc']   
        ]);

        return view('proses_mekanik', compact('parts'));
    }

    public function updateStep(Request $request)
    {
        try {
            $validated = $request->validate([
                'no_iwo' => 'required|uuid',
                'is_completed' => 'required|boolean',
                'keterangan' => 'nullable|string'
            ]);

            $result = DB::transaction(function () use ($validated) {
                // Get the current step
                $currentStep = work_progres::where('no_iwo', $validated['no_iwo'])
                    ->where('is_completed', false)
                    ->orderBy('step_order', 'asc')
                    ->first();

                if (!$currentStep) {
                    throw new \Exception('No active step found');
                }

                // Update current step
                $currentStep->update([
                    'is_completed' => true,
                    'completed_at' => now(),
                    'keterangan' => $validated['keterangan'] ?? null
                ]);

                // Get next step
                $nextStep = work_progres::where('no_iwo', $validated['no_iwo'])
                    ->where('step_order', '>', $currentStep->step_order)
                    ->orderBy('step_order', 'asc')
                    ->first();

                if ($nextStep) {
                    // Set next step as active
                    $nextStep->update([
                        'is_completed' => false,
                        'completed_at' => null,
                        'keterangan' => null
                    ]);
                }

                // Check if all steps are completed
                $allStepsCompleted = !work_progres::where('no_iwo', $validated['no_iwo'])
                    ->where('is_completed', false)
                    ->exists();

                return [
                    'message' => 'Step updated successfully',
                    'all_completed' => $allStepsCompleted,
                    'current_step' => $currentStep->step_name,
                    'next_step' => $nextStep ? $nextStep->step_name : null
                ];
            });

            return response()->json($result);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
