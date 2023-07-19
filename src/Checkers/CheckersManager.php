<?php

namespace Kettasoft\Gatekeeper\Checkers;

use Kettasoft\Gatekeeper\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Checkers\Role\RoleChecker;
use Kettasoft\Gatekeeper\Checkers\User\UserChecker;
use Kettasoft\Gatekeeper\Checkers\Role\RoleQueryChecker;
use Kettasoft\Gatekeeper\Checkers\User\UserQueryChecker;
use Kettasoft\Gatekeeper\Checkers\Role\RoleDefaultChecker;
use Kettasoft\Gatekeeper\Checkers\User\UserDefaultChecker;

class CheckersManager
{
    public function __construct(protected Role|Model $model)
    {
    }

    /**
     * Return the right checker according to the configuration.
     */
    public function getUserChecker(): UserChecker
    {
        $checker = config('gatekeeper.checkers.user', config('gatekeeper.checker', 'default'));

        switch ($checker) {
            case 'default':
                return new UserDefaultChecker($this->model);
            case 'query':
                return new UserQueryChecker($this->model);
            default:
                if (!is_a($checker, UserChecker::class, true)) {
                    throw new \RuntimeException('User checker must extend UserChecker');
                }

                return app()->make($checker, ['user' => $this->model]);
        }
    }

    /**
     * Return the right checker according to the configuration.
     */
    public function getRoleChecker(): RoleChecker
    {
        $checker = config('gatekeeper.checkers.role', config('gatekeeper.checker', 'default'));

        switch ($checker) {
            case 'default':
                return new RoleDefaultChecker($this->model);
            case 'query':
                return new RoleQueryChecker($this->model);
            default:
                if (! is_a($checker, RoleChecker::class, true)) {
                    throw new \RuntimeException('Role checker must extend RoleChecker');
                }

                return app()->make($checker, ['role' => $this->model]);
        }
    }
}
