<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DateHelper
{
    public static function calculateWorkingDeadline($startDate, $workingDays = 20)
    {
        $date = Carbon::parse($startDate);
        $holidays = collect();

        $year = $date->year;
        $response = Http::get("https://dayoffapi.vercel.app/api?year={$year}");
        if ($response->successful()) {
            $holidays = collect($response->json())->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('Y-m-d'));
        }

        $count = 0;
        while ($count < $workingDays) {
            $date->addDay();
            if (!$date->isWeekend() && !$holidays->contains($date->format('Y-m-d'))) {
                $count++;
            }
        }

        return $date;
    }

    public static function daysLeftUntilDeadline($incomingDate)
    {
        $deadline = self::calculateWorkingDeadline($incomingDate);
        $today = Carbon::today();

        return $today->diffInWeekdays($deadline, false);
    }
}
