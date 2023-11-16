<?php

namespace App\Providers;

use App\Services\FacadeService;
use App\Services\SimpleService;
use Illuminate\Support\ServiceProvider;

class FacadeDependencyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind("custom-service", function () {
            return new FacadeService("TheoServicio");
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
