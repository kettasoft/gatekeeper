<?php

namespace Kettasoft\Gatekeeper\Contracts;

use Illuminate\Database\Eloquent\Model;

interface GatekeeperInterface
{
    /**
     * Add direct permissions to the user.
     *
     * @param array|Model $permission
     * @return self
     */
    public function givePermission(array|Model $permission): static;
    public function removePermission(string|array $permission): static;
}
