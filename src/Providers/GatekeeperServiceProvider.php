<?php

namespace Kettasoft\Gatekeeper\Providers;

use Illuminate\Support\ServiceProvider;
use Kettasoft\Gatekeeper\Commands\RunMigraitonsCommand;

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
        $this->configure();
        $this->commands(RunMigraitonsCommand::class);
    }

    /**
     * Setup the configuration for Gatekeeper.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/gatekeeper.php', 'gatekeeper');
    }

}
