<?php

namespace Kettasoft\Gatekeeper\Contracts;

use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

interface AssignerInterface
{
    public function __construct(GatekeeperInterface $model);

    public function currentUserGivePermission(string|array $permission): GatekeeperInterface;
    public function currentUserRemovePermission(string|array $permission): GatekeeperInterface;
}
