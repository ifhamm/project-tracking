<?php

namespace App\Services;

use App\Models\part;
use App\Models\work_progres;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\KomponenSelesaiNotification;

class StepUpdateService
{
    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $currentStep = work_progres::where('no_iwo', $data['no_iwo'])
                ->where('is_completed', false)
                ->orderBy('step_order')
                ->first();

            if (!$currentStep) {
                return $this->handleAllStepsCompleted($data['no_iwo']);
            }

            $currentStep->update([
                'is_completed' => true,
                'completed_at' => now('Asia/Jakarta'),
                'keterangan' => $data['keterangan'] ?? null
            ]);

            $nextStep = work_progres::where('no_iwo', $data['no_iwo'])
                ->where('step_order', '>', $currentStep->step_order)
                ->orderBy('step_order')
                ->first();

            if ($nextStep) {
                $nextStep->update([
                    'is_completed' => false,
                    'completed_at' => null,
                    'keterangan' => null
                ]);
            }

            if (!$nextStep) {
                $this->sendCompletionEmail($data['no_iwo']);
            }

            return [
                'message' => 'Step updated successfully',
                'all_completed' => !$nextStep, // Ini yang akan kita gunakan
                'current_step' => $currentStep->step_name,
                'next_step' => $nextStep?->step_name
            ];
        });
    }

    protected function handleAllStepsCompleted($no_iwo)
    {
        $this->sendCompletionEmail($no_iwo);
        return [
            'message' => 'Semua langkah sudah selesai',
            'all_completed' => true,  
            'current_step' => null,
            'next_step' => null
        ];
    }

    protected function sendCompletionEmail($no_iwo)
    {
        // Fetch the part (komponen)
        $komponen = part::where('no_iwo', $no_iwo)->first();

        if ($komponen) {
            // Explicitly get the latest completed work_progres for this no_iwo
            $latestCompletedWorkProgres = work_progres::where('no_iwo', $no_iwo)
                ->where('is_completed', true)
                ->orderByDesc('completed_at')
                ->first();

            if ($latestCompletedWorkProgres) {
                $latestCompletedAt = $latestCompletedWorkProgres->completed_at;

                Mail::to(config('mail.notify_admin'))->send(
                    new KomponenSelesaiNotification($komponen, $latestCompletedAt)
                );
            }
        }
    }
}
