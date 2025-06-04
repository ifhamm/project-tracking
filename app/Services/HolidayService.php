<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HolidayService
{
    public function getHolidays($year): Collection
    {
        return Cache::remember("holidays:$year", now()->addDays(1), function () use ($year) {
            $response = Http::get("https://dayoffapi.vercel.app/api?year={$year}");
            if ($response->successful()) {
                return collect($response->json())->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('Y-m-d'));
            }
            return collect();
        });
    }
}
