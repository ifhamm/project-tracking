<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\UpdateStepRequest;
use App\Services\StepUpdateService;
use Illuminate\Http\Request;
use App\Models\part;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProsesMekanikController extends Controller
{
    protected DateHelper $dateHelper;

    public function __construct(DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
    }

    public function index(Request $request)
    {
        $query = part::with(['akunMekanik', 'workProgres' => fn($q) => $q->orderBy('step_order')])
            ->whereHas('workProgres', fn($q) => $q->where('is_completed', false));

        if ($request->filled('no_wbs')) {
            $query->where('no_wbs', 'like', '%' . $request->no_wbs . '%');
        }

        if ($request->filled('teknisi')) {
            $query->whereHas('akunMekanik', fn($q) => $q->where('name', 'like', '%' . $request->teknisi . '%'));
        }

        if ($request->filled('step')) {
            $searchStep = trim($request->step);
            
            // Get parts that have the searched step as their current (incomplete) step
            $query->whereHas('workProgres', function($q) use ($searchStep) {
                $q->where('step_name', '=', $searchStep)
                  ->where('is_completed', false)
                  ->whereNotExists(function($subquery) {
                      $subquery->select(DB::raw(1))
                              ->from('work_progres as wp2')
                              ->whereRaw('wp2.no_iwo = work_progres.no_iwo')
                              ->where('wp2.step_order', '<', DB::raw('work_progres.step_order'))
                              ->where('wp2.is_completed', false);
                  });
            });
        }

        $parts = $query->paginate(10);

        // Transform and add urgency information
        $parts->getCollection()->transform(function ($part) {
            $currentStep = $part->workProgres->where('is_completed', false)->first();
            
            // Debug log for each part's current step
            Log::info('Part current step:', [
                'part_id' => $part->id,
                'current_step' => $currentStep ? $currentStep->step_name : 'No current step'
            ]);
            
            $nextStep = $part->workProgres->where('step_order', '>', optional($currentStep)->step_order)->first();

            $part->next_step = $nextStep?->step_name;
            
            // Set urgency level (2 for red, 1 for yellow, 0 for normal)
            if ($part->is_urgent) {
                $part->urgency_level = 2;
                $part->urgency_icon = 'red';
            } else {
                $part->urgency_level = 0;
                $part->urgency_icon = null;
                
                if ($part->incoming_date) {
                    $daysLeft = $this->dateHelper->daysLeftUntilDeadline($part->incoming_date);
                    $part->days_left = $daysLeft;
                    if ($daysLeft <= 5) {
                        $part->urgency_level = 1;
                        $part->urgency_icon = 'yellow';
                    }
                }
            }

            return $part;
        });

        // Sort by urgency level (2 = red, 1 = yellow, 0 = normal)
        $sortedCollection = $parts->getCollection()->sortByDesc('urgency_level');
        $parts->setCollection($sortedCollection);

        return view('proses_mekanik', compact('parts'));
    }

    public function updateStep(UpdateStepRequest $request, StepUpdateService $service)
    {
        try {
            $result = $service->update($request->validated());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
