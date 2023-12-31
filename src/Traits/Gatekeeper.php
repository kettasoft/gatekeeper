<?php

namespace Kettasoft\Gatekeeper\Traits;

use Kettasoft\Gatekeeper\Checkers\CheckersManager;
use Kettasoft\Gatekeeper\Checkers\User\UserChecker;
use Kettasoft\Gatekeeper\Services\Assigner;
use Kettasoft\Gatekeeper\Traits\GatekeeperAssigner;

trait Gatekeeper
{
    use GatekeeperChecks;
    use GatekeeperUserRelations;
    use GatekeeperAssigner;
    use GatekeeperCacheing;

    /**
     * Return the right checker for the user model.
     */
    public function gatekeeperUserChecker(): UserChecker
    {
        return (new CheckersManager($this))->getUserChecker();
    }

    public function gatekeeperUserAssginer(): Assigner
    {
        return (new Assigner($this));
    }
}
