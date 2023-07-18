<?php

namespace Kettasoft\Gatekeeper\Providers;

use Illuminate\Support\ServiceProvider;

class GatekeeperServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/gatekeeper.php' => config_path('gatekeeper.php')
        ], 'config');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
