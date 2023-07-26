<?php

namespace Kettasoft\Gatekeeper\Traits;

use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

trait GatekeeperAssigner
{
    /**
     * Add direct permissions to the user.
     */
    public function givePermission(
        array|Model $permission,
    ): static {
        return $this->gatekeeperUserAssginer()->currentUserGivePermission($permission);
    }

    public function removePermission(string|array $permission)
    {
        return $this->gatekeeperUserAssginer()->currentUserRemovePermission($permission);
    }
}
