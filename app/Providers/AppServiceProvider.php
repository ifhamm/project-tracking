<?php

namespace App\Providers;

use App\Observers\PartObserver;
use App\Models\Part;
use Illuminate\Support\ServiceProvider;
use App\Helpers\DateHelper;
use App\Services\HolidayService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

public function register(): void
{
    $this->app->singleton(DateHelper::class, function ($app) {
        return new DateHelper($app->make(HolidayService::class));
    });
}


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Part::observe(PartObserver::class);
    }
}
