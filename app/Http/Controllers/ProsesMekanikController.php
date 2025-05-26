<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\part;
use App\Models\work_progres;
use Illuminate\Http\Request;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;
use App\Mail\KomponenSelesaiNotification;
use App\Models\akun_mekanik;

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
                $q->where('name', 'like', '%' . $request->teknisi . '%');
            });
        }

        // Search by current step
        if ($request->filled('step')) {
            $query->whereHas('workProgres', function ($q) use ($request) {
                $q->where('step_name', 'like', '%' . $request->step . '%')
                    ->where('is_completed', false);
            });
        }

        // Get paginated results
        $parts = $query->paginate(10);

        // Add additional data to each part
        $parts->getCollection()->transform(function ($part) {
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
                    $part->urgency_icon = 'yellow';
                }
            }

            return $part;
        });

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
                    // Sebaliknya dari error, ini berarti semua step sudah selesai
                    $komponen = part::where('no_iwo', $validated['no_iwo'])->first();
                    if ($komponen) {
                        Mail::to('muhamadilhamfauzi18@gmail.com')->send(new KomponenSelesaiNotification($komponen));
                    }

                    return [
                        'message' => 'Semua langkah sudah selesai',
                        'all_completed' => true,
                        'current_step' => null,
                        'next_step' => null
                    ];
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

                // Kirim email jika semua langkah selesai
                if ($allStepsCompleted) {
                    $komponen = part::where('no_iwo', $validated['no_iwo'])->first();

                    if ($komponen) {
                        Mail::to('muhamadilhamfauzi18@gmail.com')->send(new KomponenSelesaiNotification($komponen));
                    }
                }

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
