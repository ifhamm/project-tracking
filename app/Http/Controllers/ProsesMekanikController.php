<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\UpdateStepRequest;
use App\Services\StepUpdateService;
use Illuminate\Http\Request;
use App\Models\part;

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
            $query->whereHas(
                'workProgres',
                fn($q) =>
                $q->where('step_name', 'like', '%' . $request->step . '%')->where('is_completed', false)
            );
        }

        $parts = $query->paginate(10);

        $parts->getCollection()->transform(function ($part) {
            $currentStep = $part->workProgres->where('is_completed', false)->first();
            $nextStep = $part->workProgres->where('step_order', '>', optional($currentStep)->step_order)->first();

            $part->next_step = $nextStep?->step_name;
            $part->urgency_icon = $part->is_urgent ? 'red' : null;
            $part->days_left = null;

            if (!$part->is_urgent && $part->incoming_date) {
                $daysLeft = $this->dateHelper->daysLeftUntilDeadline($part->incoming_date);
                $part->days_left = $daysLeft;
                if ($daysLeft <= 5) {
                    $part->urgency_icon = 'yellow';
                }
            }

            return $part;
        });

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
