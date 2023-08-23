<?php

namespace Kettasoft\Gatekeeper;

use Illuminate\Contracts\Foundation\Application;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

class Gatekeeper
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Checks if the current user has a permission by its name.
     */
    public function hasPermission(
        string|array $permission,
        bool $requireAll = false
    ): bool {
        if ($user = $this->user()) {
            return $user->hasPermission($permission, $requireAll);
        }

        return false;
    }

    /**
     * Get the currently authenticated user or null.
     */
    protected function user()
    {
        return $this->app->auth->user();
    }
}
