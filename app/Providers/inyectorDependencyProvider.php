<?php

namespace App\Providers;

use App\Services\SimpleService;
use Illuminate\Support\ServiceProvider;


class inyectorDependencyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->bind(SimpleService::class, function () {
            return new SimpleService("TheoServicio");
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
