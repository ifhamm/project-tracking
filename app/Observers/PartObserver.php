<?php

namespace App\Observers;

use App\Models\Part;
use App\Helpers\DateHelper;

class PartObserver
{
    public function creating(Part $part)
    {
        if ($part->incoming_date && !$part->priority_deadline_date) {
            $dateHelper = app(DateHelper::class); // Resolve dari container
            $part->priority_deadline_date = $dateHelper->calculateWorkingDeadline($part->incoming_date);
        }
    }


    /**
     * Handle the Part "updated" event.
     */
    public function updated(Part $part): void
    {
        //
    }

    /**
     * Handle the Part "deleted" event.
     */
    public function deleted(Part $part): void
    {
        //
    }

    /**
     * Handle the Part "restored" event.
     */
    public function restored(Part $part): void
    {
        //
    }

    /**
     * Handle the Part "force deleted" event.
     */
    public function forceDeleted(Part $part): void
    {
        //
    }
}
