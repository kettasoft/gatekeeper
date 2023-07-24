<?php

namespace Kettasoft\Gatekeeper\Checkers\User;

use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

abstract class UserChecker
{
    public function __construct(protected GatekeeperInterface|Model $user)
    {
    }

    /**
     * Check if cuurent logged in user has permission
     *
     * @param string|array $permission
     * @param boolean $requireAll
     * @return boolean
     */
    abstract public function currentUserHasPermission(string|array $permission, bool $requireAll = false): bool;
}
