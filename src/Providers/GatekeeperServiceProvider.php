<?php

namespace Kettasoft\Gatekeeper\Providers;

use Illuminate\Support\ServiceProvider;
use Kettasoft\Gatekeeper\Commands\RunMigraitonsCommand;
use Kettasoft\Gatekeeper\Gatekeeper;

class GatekeeperServiceProvider extends ServiceProvider
{
    /**
     * The middlewares to be registered.
     *
     * @var array
     */
    protected array $middlewares = [
        'role' => \Kettasoft\Gatekeeper\Middleware\Role::class,
        'permission' => \Kettasoft\Gatekeeper\Middleware\Permission::class
    ];

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
        $this->registerMiddlewares();
        $this->registerGatekeeper();
        $this->commands(RunMigraitonsCommand::class);
    }

    /**
     * Setup the configuration for Gatekeeper.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/gatekeeper.php', 'gatekeeper');
    }

    /**
     * Register the middlewares automatically.
     *
     * @return void
     */
    protected function registerMiddlewares()
    {
        if (!$this->app['config']->get('gatekeeper.middleware.register')) {
            return;
        }

        $router = $this->app['router'];

        switch (true) {
            case method_exists($router, 'aliasMiddleware'):
                $registerMethod = 'aliasMiddleware';
                break;
            case method_exists($router, 'middleware'):
                $registerMethod = 'middleware';
                break;
            default:
                return;
        }

        foreach ($this->middlewares as $key => $class) {
            $router->$registerMethod($key, $class);
        }
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    protected function registerGatekeeper()
    {
        $this->app->bind('Gatekeeper', function ($app) {
            return new Gatekeeper($app);
        });

        $this->app->alias('gatekeeper', Gatekeeper::class);
    }
}
