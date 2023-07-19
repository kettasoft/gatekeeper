<?php

namespace Kettasoft\Gatekeeper\Checkers\User;

use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

abstract class UserChecker
{
    public function __construct(protected GatekeeperInterface|Model $user)
    {
    }
}
