<?php

namespace Gatekeeper\Tests;

use Gatekeeper\Tests\Models\User;
use Kettasoft\Gatekeeper\GatekeeperFacade;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Kettasoft\Gatekeeper\Providers\GatekeeperServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;
    /**
     * Setup DB before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->getEnvironmentSetUp($this->app);

        $this->loadMigrationsFrom([
            '--path' => realpath(__DIR__ . '/database/migrations'),
        ]);

        $this->artisan('migrate', [
            '--path' => realpath(__DIR__ . '/database/migrations'),
        ]);

        $this->guessFactoryNamesUsing();
    }

    protected function guessFactoryNamesUsing()
    {
        return Factory::guessFactoryNamesUsing(fn ($name) => (string) '\Gatekeeper\Tests\Database\Factories\\'. (class_basename($name)) .'Factory');
    }

    protected function getPackageProviders($app)
    {
        return [
            GatekeeperServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default','sqlite');
        $app['config']->set('database.connections.sqlite.database', __DIR__ . '/./database/database.sqlite');
        $app['config']->set('cache.default', 'array');
        $app['config']->set('gatekeeper.user_models', ['users' => User::class]);

        $app['config']->set('gatekeeper.panel.register', true);
        $app['config']->set('gatekeeper.models', [
            'role' => 'Gatekeeper\Tests\Models\Role',
            'permission' => 'Gatekeeper\Tests\Models\Permission'
        ]);
    }

    protected function getPackageAliases($app)
    {
        return [
            'Gatekeeper' => GatekeeperFacade::class,
        ];
    }
}
