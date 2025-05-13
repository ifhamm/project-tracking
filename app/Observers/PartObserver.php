<?php

namespace App\Observers;

use App\Models\Part;

class PartObserver
{
    /**
     * Handle the Part "created" event.
     */
    public function creating(Part $part)
    {
        if ($part->incoming_date && !$part->priority_date) {
            $part->priority_deadline_date = \App\Helpers\DateHelper::calculateWorkingDeadline($part->incoming_date);
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
