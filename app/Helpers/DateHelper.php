<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Services\HolidayService;

class DateHelper
{
    protected HolidayService $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }

    public function calculateWorkingDeadline($startDate, $workingDays = 20)
    {
        $date = Carbon::parse($startDate);
        $holidays = $this->holidayService->getHolidays($date->year);

        $count = 0;
        while ($count < $workingDays) {
            $date->addDay();
            if (!$date->isWeekend() && !$holidays->contains($date->format('Y-m-d'))) {
                $count++;
            }
        }

        return $date;
    }

    public function daysLeftUntilDeadline($incomingDate)
    {
        $deadline = $this->calculateWorkingDeadline($incomingDate);
        $today = Carbon::today();

        return $today->diffInDaysFiltered(function ($date) use ($deadline) {
            return $date->isWeekday();
        }, $deadline);
    }
}
