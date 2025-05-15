<?php

namespace App\Providers;

use App\Observers\PartObserver;
use App\Models\Part;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Part::observe(PartObserver::class);
    }
}
